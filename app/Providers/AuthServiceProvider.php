<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        Gate::define('manager', function ($user) {
        if($user->type == 'Manager')
            return true;
        return false;
    });
        Gate::define('waiter', function ($user) {
        if($user->type == 'Waiter')
            return true;
        return false;
    });
        Gate::define('chef', function ($user) {
        if($user->type == 'Chef')
            return true;
        return false;
    });
    }
}
