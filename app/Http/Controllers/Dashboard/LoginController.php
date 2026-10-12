<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\AuthEvent;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
     private $redirect =  '/';

    public function showLoginForm()
    {
        return view('dashboard.auth.index');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        $throttleKey = $this->throttleKey($request);
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return redirect()
                ->route('login')
                ->with('error', 'Too many login attempts. Please try again in ' . $seconds . ' seconds.')
                ->withInput($request->only('email', 'remember'));
        }
        $result = $this->attemptLogin($request);
        if ($result['success']) {
            $request->session()->regenerate();
            session(['user_id' => Auth::id()]);
            $request->session()->save();
            RateLimiter::clear($throttleKey);
            $user = Auth::user();
            $this->authAudit($user, ['event_type' => 'login']);
            if ($user->hasRole('Super admin')) {
                return redirect()->route('settings');
            }

            // Candidate users redirect to candidate portal on HR
            if ($user->isCandidate()) {
                $hrUrl = rtrim(config('app.HR_URL'), '/');
                // Use local URL for .test domains
                if (str_contains($request->getHost(), '.test')) {
                    $hrUrl = 'http://hr.upedia.test';
                }
                return redirect($hrUrl . '/candidate/dashboard');
            }

            $departmentSlug = $user->staff?->department?->slug ?? null;

            $empUrl = config('app.HR_URL');
            if (str_contains($request->getHost(), '.test')) {
                $empUrl = 'http://hr.upedia.test';
            }
            return redirect($empUrl);

            // switch ($departmentSlug) {
            //     case 'hr':
            //         return redirect(config('app.HR_URL'));
            //     case 'academy':
            //         return redirect(config('app.ACADEMY_URL'));
            //     case 'finance':
            //         return redirect(config('app.FINANCE_URL'));
            //     case 'crm':
            //         return redirect(config('app.CRM_URL'));
            //     case 'retention':
            //         return redirect(config('app.Retention_URL'));
            //     case 'it':
            //         return redirect(config('app.IT_URL'));
            //     default:
            //         return redirect(config('app.SETTINGS_URL'));
            // }
        }

        RateLimiter::hit($throttleKey, 300);

        return redirect()->route('login')->with('error', $result['message'])->withInput($request->only('email', 'remember'));
    }

    protected function throttleKey(Request $request)
    {
        return strtolower($request->input('email')) . '|' . $request->ip();
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ], [
            'email.required' => 'Please enter your phone number or email.',
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        $rawInput = $request->input('email');
        $input = preg_replace('/[^0-9+]/', '', $rawInput);
        $password = $request->input('password');
        $remember = $request->filled('remember');

        $user = User::with(['staff.department'])->where(function ($q) use ($rawInput, $input) {
            $q->where('email', $rawInput)
                ->orWhere('phone_number', ltrim($input, '+'))
                ->orWhereRaw("REPLACE(CONCAT(mobile_dial_code, phone_number), '+', '') = ?", [ltrim($input, '+')]);
        })->first();

        if (!$user) {

            return ['success' => false, 'message' => 'Invalid phone number, email, or password.'];
            // return ['success' => false, 'message' => 'No user found with provided credentials.'];

        }

        // Candidate users don't need a Staff record to login
        if ($user->isCandidate()) {

            if (Auth::attempt(['email' => $user->email, 'password' => $password], $remember)) {
                return ['success' => true, 'message' => 'Login successful.'];
            } else {
                return ['success' => false, 'message' => 'Invalid phone number, email, or password.'];
            }
        }

        $staff = $user->staff;

        if (!$staff || $staff->active_status != 1) {
            return ['success' => false, 'message' => 'Your account is inactive. Please contact support.'];
        }

        if (!$user->roles()->exists()) {
            return ['success' => false, 'message' => 'Your account has no role assigned. Please contact support.'];
        }

        $department = $staff?->department;

        // if ($department && in_array($department->slug, ['tester', 'teacher'])) {
        //     return ['success' => false, 'message' => 'You are not allowed to login from this portal.'];
        // }

        if (Auth::attempt(['email' => $user->email, 'password' => $password], $remember)) {
            return ['success' => true, 'message' => 'Login successful.'];
        } else {
            return ['success' => false, 'message' => 'Invalid phone number, email, or password.'];
        }
    }

    public function fcmToken(Request $request)
    {
        // $request->validate([
        //     'token' => 'required|string|unique:users,fcm_token',
        //     'device' => 'nullable|string'
        // ]);

        $request->user()->update([
            'fcm_token' => $request->token,
        ]);

        return response()->json(['message' => 'FCM Token saved']);
    }

    public function logout()
    {

        if ($this->hasExcludedJobTitle(auth()->id())) {
            return  $this->logoutUser();
        }

        // Candidate users skip attendance check-out
        $user = Auth::user();
        if ($user && $user->isCandidate()) {
            return $this->logoutUser();
        }

        $logoutType = request()->get('type');
        $staff_id = \auth()->user()->staff->id ?? null;
        if(!$logoutType && !$this->UserHasTodayAttendence($user = Auth::user(), 'check_out')) {
            if (request()->ajax()){
                return response()->json([
                    'status'   =>  false,
                    'test_url' =>  config('app.hr_attendance_url'),
                    'message' => 'You have not checked out today.'
                ]);
            }
        }

        if (isset($logoutType) &&  $logoutType == 'checkout') {
            try {
                  DB::beginTransaction();
                $checkedOut = DB::table('sm_staff_attendences')
                    ->where('staff_id', $staff_id)
                    ->where('attendence_date', now()->toDateString())
                    ->update(['check_out' => now()]);
                    $this->logoutUser();
                    DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Checked out successfully.' ,
                    'redirect' => route('login')
                   ]);
                }
             catch (\Throwable $e) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
        }

      return  $this->logoutUser();
    }

    private  function UserHasTodayAttendence($user, $type)
    {

        $today = now()->format('Y-m-d');
        $attendance = DB::table('sm_staff_attendences')
            ->where('staff_id', $user->staff->id)
            ->where('attendence_date', $today)
            ->whereNotNull($type)
            ->exists();
        return $attendance;
    }

    public function logoutUser():JsonResponse
    {
        $userId = Auth::id();
        $user = Auth::user();
        $staff_id = $user->staff->id ?? null;
        $this->authAudit($user, ['event_type' => 'logout']);
        DB::table('sessions')
            ->where('user_id', $userId)
            ->delete();
        Auth::logout();
        $redirectUrl =   config('app.redirect_url');


        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully.',
            'redirect' => $redirectUrl
        ]);
    }

    public function authAudit(User $user , $data)
    {
        $data =  [
            'user_id' => $user->id,
            'event_type' => $data['event_type'],
            'created_at' => now(),
            'updated_at' => now(),
        ];
      return  AuthEvent::create($data);

    }


    protected function hasExcludedJobTitle(int $userId): bool
    {
        $job = DB::table('users')
            ->join('sm_staffs', 'users.id', '=', 'sm_staffs.user_id')
            ->join('hr_job_titles', 'sm_staffs.job_title_id', '=', 'hr_job_titles.id')
            ->where('users.id', $userId)
            ->value('hr_job_titles.slug');

        return in_array($job, ['tester', 'teacher']);
    }

    public function consumeIframeSessionLink(Request $request, User $user)
    {
        if (! $user->isCandidate()) {
            $staff = $user->staff;

            if (! $staff || $staff->active_status != 1) {
                return redirect()->route('auth.login')->with('error', 'Your account is inactive. Please contact support.');
            }

            if (! $user->roles()->exists()) {
                return redirect()->route('auth.login')->with('error', 'Your account has no role assigned. Please contact support.');
            }
        }

        Auth::login($user);
        $request->session()->regenerate();
        session(['user_id' => $user->id]);
        $request->session()->save();
        $this->authAudit($user, ['event_type' => 'login']);


        return redirect($this->redirect);
    }

    public function createIframeTokenLink(Request $request): JsonResponse
    {
        $secret = (string) env('IFRAME_SSO_SHARED_SECRET', '');
        $incomingSecret = (string) $request->header('X-SSO-SECRET', '');

        if ($secret === '' || !hash_equals($secret, $incomingSecret)) {

            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'email' => ['required', 'string', 'email','exists:users,email'],
        ]);

        if (empty($validated['user_id']) && empty($validated['email'])) {
            return response()->json(['message' => 'user_id or email is required.'], 422);
        }

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $token = $user->createToken('iframe-sso', ['iframe-access'])->plainTextToken;
        $iframeUrl = rtrim((string) config('app.HR_URL'));
        $separator = str_contains($iframeUrl, '?') ? '&' : '?';
        $iframeUrl .= $separator . 'sso_token=' . urlencode($token);

        return response()->json(['url' => $iframeUrl,'token_type' => 'Bearer','expires_in_seconds' => null]);
    }
}
