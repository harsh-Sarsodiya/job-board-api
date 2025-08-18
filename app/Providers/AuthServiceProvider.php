<?php

namespace App\Providers;

use App\Models\Job;
use App\Policies\JobPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Job::class => JobPolicy::class,
    ];

    /**
     * Register any authentication/authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Admins bypass all permission checks
        Gate::before(function ($user, $ability) {
            return $user->isAdmin() ? true : null;
        });
    }
}
