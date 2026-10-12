<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Config;
use App\Models\Tab;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();


        Paginator::useBootstrapFive();
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        Config::set('app.client_name', 'Upedia');
        config::set('app.general_link', 'https://upedia-setting.thetailors.tech/systems/');
        // config::set('app.general_link', 'https://setting.upedia.test/systems/');


        $host = Request::getHost();

        if (str_contains($host, 'alkarim')) {
            Config::set('app.client_name', 'Alkarim');
            Config::set('app.client_name', 'Alkarim');
            config::set('app.general_link', 'https://alkarim-setting.thetailors.tech/systems');

            config::set('app.SETTINGS_URL', 'https://alkarim-setting.thetailors.tech/');
            config::set('app.ACADEMY_URL', 'https://alkarim-academic.thetailors.tech/');
            config::set('app.HR_URL', 'https://alkarim-hr.thetailors.tech/');
            config::set('app.FINANCE_URL', 'https://alkarim-finance.thetailors.tech/');
            config::set('app.CRM_URL', 'https://alkarim-crm.thetailors.tech/');
            config::set('app.Retention_URL', 'https://alkarim-retention.thetailors.tech/');
            config::set('app.EXAM_URL', 'https://alkarim-exam2.thetailors.tech/');
            config::set('app.IT_URL', 'https://alkarim-it.thetailors.tech/');

            config::set('app.MARKETING_URL', 'https://alkarim-marketing.thetailors.tech/');
        } elseif (str_contains($host, 'upedia')) {
            Config::set('app.client_name', 'Upedia');
            config::set('app.general_link', 'https://upedia-setting.thetailors.tech/systems/');

            config::set('app.SETTINGS_URL', 'https://upedia-setting.thetailors.tech/');
            config::set('app.ACADEMY_URL', 'https://upedia-academic.thetailors.tech/');
            config::set('app.EXAM_URL', 'https://upedia-exam2.thetailors.tech/');
            config::set('app.HR_URL', 'https://upedia-hr.thetailors.tech/');
            config::set('app.FINANCE_URL', 'https://upedia-finance.thetailors.tech/');
            config::set('app.CRM_URL', 'https://upedia-crm.thetailors.tech/');
            config::set('app.Retention_URL', 'https://upedia-retention.thetailors.tech/');
            config::set('app.IT_URL', 'https://upedia-it.thetailors.tech/');
            config::set('app.MARKETING_URL', 'https://upedia-marketing.thetailors.tech/');

            // config::set('app.general_link', 'https://setting.upedia.test/systems/');
            // config::set('app.SETTINGS_URL', 'https://setting.upedia.test/');
            // config::set('app.ACADEMY_URL', 'https://academic.upedia.test/');
            // config::set('app.EXAM_URL', 'https://exam.upedia.test/');
            // config::set('app.HR_URL', 'https://hr.upedia.test/');
            // config::set('app.FINANCE_URL', 'https://finance.upedia.test/');
            // config::set('app.CRM_URL', 'https://crm.upedia.test/');
            // config::set('app.Retention_URL', 'https://retention.upedia.test/');
            // config::set('app.IT_URL', 'https://it.upedia.test/');
            // config::set('app.MARKETING_URL', 'https://marketing.upedia.test/');
        } else {
         Config::set('app.client_name', 'tailors');
            config::set('app.general_link', 'https://tailors-setting.thetailors.tech/systems');
            config::set('app.SETTINGS_URL', 'https://tailors-setting.thetailors.tech/');
            config::set('app.ACADEMY_URL', 'https://tailors-academic.thetailors.tech/');
            config::set('app.HR_URL', 'https://tailors-hr.thetailors.tech/');
            config::set('app.FINANCE_URL', 'https://tailors-finance.thetailors.tech/');
            config::set('app.CRM_URL', 'https://tailors-crm.thetailors.tech/');
            config::set('app.Retention_URL', 'https://tailors-retention.thetailors.tech/');
            config::set('app.EXAM_URL', 'https://tailors-exam2.thetailors.tech/');
            config::set('app.IT_URL', 'https://tailors-it.thetailors.tech/');
            config::set('app.MARKETING_URL', 'https://tailors-marketing.thetailors.tech/');
        }

        View::composer('components.sidebar', function ($view) {
            if (!Auth::check()) {
                return;
            }

            $ssoToken = (string) request()->query('sso_token', '');
            if ($ssoToken === '') {
                $referer = (string) request()->headers->get('referer', '');
                if ($referer !== '') {
                    parse_str((string) data_get(parse_url($referer), 'query', ''), $refererQuery);
                    $ssoToken = (string) ($refererQuery['sso_token'] ?? '');
                }
            }

            $appendSsoToken = function (?string $url) use ($ssoToken): ?string {
                if (!$url || $url === '#' || str_contains($url, 'javascript:void(0)') || $ssoToken === '') {
                    return $url;
                }

                $parts = parse_url($url);
                if ($parts === false) {
                    return $url;
                }

                $query = [];
                if (!empty($parts['query'])) {
                    parse_str($parts['query'], $query);
                }

                if (!isset($query['sso_token']) || $query['sso_token'] === '') {
                    $query['sso_token'] = $ssoToken;
                }

                $scheme = isset($parts['scheme']) ? $parts['scheme'] . '://' : '';
                $host = $parts['host'] ?? '';
                $port = isset($parts['port']) ? ':' . $parts['port'] : '';
                $path = $parts['path'] ?? '';
                $fragment = isset($parts['fragment']) ? '#' . $parts['fragment'] : '';
                $queryString = http_build_query($query);

                if ($host !== '') {
                    return $scheme . $host . $port . $path . ($queryString !== '' ? '?' . $queryString : '') . $fragment;
                }

                return $path . ($queryString !== '' ? '?' . $queryString : '') . $fragment;
            };

            $currentHost = Request::getHost();
            $sessionKey = 'menuTabs_' . $currentHost;

            if (Session::has($sessionKey)) {
                return;
            }

            $user = Auth::user();
            $isSuperAdmin = $user->hasRole('Super admin');
            $permissionChecks = [];
            $canAccess = function (?string $permission) use ($user, $isSuperAdmin, &$permissionChecks): bool {
                if ($isSuperAdmin) {
                    return true;
                }

                if (!$permission) {
                    return true;
                }

                if (!array_key_exists($permission, $permissionChecks)) {
                    $permissionChecks[$permission] = $user->can($permission);
                }

                return $permissionChecks[$permission];
            };

            if ($isSuperAdmin) {
                // $tabs = Tab::whereNull('parent_id')
                //     ->with(['children' => function ($query) {
                //         $query->orderBy('order', 'asc');
                //     }])
                //     ->orderBy('order', 'asc')->get();

                $tabs = Tab::with('children')->orderBy('order')->get();

            } else {
                $department = $user->staff->department ?? null;
                if ($department) {
                    $tabs = Tab::whereNull('parent_id')
                        ->whereHas('departments', function ($query) use ($department) {
                            $query->where('sm_human_departments.id', $department->id);
                        })
                        ->with(['children' => function ($q) use ($department) {
                            $q->join('department_tab', 'tabs.id', '=', 'department_tab.tab_id')
                                ->where('department_tab.department_id', $department->id)
                                ->select('tabs.*', 'department_tab.order as pivot_order')
                                ->orderBy('pivot_order', 'asc');
                        }])
                        ->join('department_tab', 'tabs.id', '=', 'department_tab.tab_id')
                        ->where('department_tab.department_id', $department->id)
                        ->select('tabs.*', 'department_tab.order as pivot_order')
                        ->orderBy('pivot_order', 'asc')
                        ->get();
                } else {
                    $tabs = collect();
                }
            }

            $tabs = $tabs->filter(fn($tab) => $canAccess($tab->permission_required))
                ->map(function ($tab) use ($canAccess, $appendSsoToken) {
                    $tab->url = $appendSsoToken($tab->url ?? null);

                    $children = $tab->children
                        ->filter(fn($child) => $canAccess($child->permission_required))
                        ->map(function ($child) use ($appendSsoToken) {
                            $child->url = $appendSsoToken($child->url ?? null);
                            return $child;
                        });

                    if ($children->contains(fn($child) => isset($child->pivot_order))) {
                        $children = $children->sortBy('pivot_order');
                    }

                    $tab->children = $children->values();

                    return $tab;
                })
                ->values();

            session([$sessionKey => $tabs]);
        });
    }
}
