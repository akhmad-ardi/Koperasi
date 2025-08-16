<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        Gate::define('is-ketua', function ($user) {
            return $user->role === 'ketua';
        });

        Gate::define('is-admin', function ($user) {
            return $user->role === 'admin';
        });
    }
}
