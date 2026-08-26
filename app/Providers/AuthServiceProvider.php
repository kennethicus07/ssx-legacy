<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->user_group === 1 ? true : null;
            //return $user->hasRole('Super Admin') ? true : null;
        });

        Gate::define('supplier-tab-action', function ($user, $tab, $action) {
            if ($user->user_group !== 5) {
                return false;
            }

            $tabActions = [
                'company_info' => ['view','save','edit'],
                'product_info' => [],
                'contact_info' => ['view','save','edit'],
                'business_info' => ['view', 'save'],
                'order_info' => [],
                'docs_requirements' => ['view','save','edit'],
            ];

            return in_array($action, $tabActions[$tab] ?? []);
        });
        
    }
}
