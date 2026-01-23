<?php

namespace App\Providers;

use App\Models\Critic;
use App\Policies\CriticPolicy;
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
        // Register the Critic policy
        Gate::policy(Critic::class, CriticPolicy::class);

        // Define an 'admin' gate
        Gate::define('admin', fn($user) => $user->role->name === 'ADMIN');
    }
}
