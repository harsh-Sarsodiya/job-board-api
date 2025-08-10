<?php

namespace App\Providers;

use App\Events\ApplicationCreated;
use App\Events\JobCreated;
use App\Listeners\NotifyAdminAboutNewJob;
use App\Listeners\NotifyEmployerAboutNewApplication;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        JobCreated::class => [
            NotifyAdminAboutNewJob::class,
        ],
        ApplicationCreated::class => [
            NotifyEmployerAboutNewApplication::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
