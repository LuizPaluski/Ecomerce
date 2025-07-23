<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('admin', function (User $user) {
            return $user->hasPermission('admin');
    });
        Gate::define('manager', function (User $user) {
            return $user->hasPermission('manager');
        });
        Gate::define('user', function (User $user) {
            return $user->hasPermission('user');
        });


    }
}
