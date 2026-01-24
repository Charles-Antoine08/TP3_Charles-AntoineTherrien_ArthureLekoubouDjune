<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\{Actor, Critic};
use App\Policies\{ActorPolicy, CriticPolicy};

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

        // Register the Actor policy
        Gate::policy(Actor::class, ActorPolicy::class);
    }
}
