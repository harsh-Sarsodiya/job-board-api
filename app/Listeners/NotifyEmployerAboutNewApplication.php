<?php

namespace App\Listeners;

use App\Events\ApplicationCreated;
use App\Notifications\NewJobApplication;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyEmployerAboutNewApplication implements ShouldQueue
{
    public function handle(ApplicationCreated $event): void
    {
        $event->application->job->user->notify(
            new NewJobApplication($event->application)
        );
    }
}
