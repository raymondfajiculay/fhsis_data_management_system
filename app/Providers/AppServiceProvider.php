<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::define('create-user', function (User $user) {
            return in_array($user->role, ['super_admin', 'admin']);
        });

        Gate::define('upload-file', function (User $user) {
            return in_array($user->role, ['admin', 'user']);
        });

        Gate::define('view-municipality', function (User $user) {
            return $user->role === 'super_admin' ? 'all' : $user->municipality;
        });

        Gate::define('select-municipality', function (User $user) {
            return $user->role === 'super_admin';
        });
    }
}
