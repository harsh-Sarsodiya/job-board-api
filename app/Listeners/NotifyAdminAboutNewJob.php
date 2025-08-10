<?php

namespace App\Listeners;

use App\Events\JobCreated;
use App\Models\User;
use App\Notifications\NewJobPosted;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAdminAboutNewJob implements ShouldQueue
{
    public function handle(JobCreated $event): void
    {
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            $admin->notify(new NewJobPosted($event->job));
        }
    }
}
