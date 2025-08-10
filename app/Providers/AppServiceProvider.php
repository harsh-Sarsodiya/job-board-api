<?php

namespace App\Providers;

use App\Interfaces\ApplicationRepositoryInterface;
use App\Interfaces\JobRepositoryInterface;
use App\Repositories\ApplicationRepository;
use App\Repositories\JobRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(JobRepositoryInterface::class, JobRepository::class);
        $this->app->bind(ApplicationRepositoryInterface::class, ApplicationRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
