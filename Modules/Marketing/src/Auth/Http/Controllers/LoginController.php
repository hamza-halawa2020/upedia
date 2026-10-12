<?php

namespace Modules\Marketing\Auth\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function logout()
    {
        $userId = Auth::id();
        DB::table('sessions')->where('user_id', $userId)->delete();
        Auth::logout();
        return redirect()->route('dashboard');
    }
}
