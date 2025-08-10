<?php

namespace App\Notifications;

use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewJobPosted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Job $job)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Job Posted - Needs Approval')
            ->line('A new job has been posted and needs your approval.')
            ->line('Job Title: ' . $this->job->title)
            ->action('View Job', url('/admin/jobs/' . $this->job->id))
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'job_id' => $this->job->id,
            'job_title' => $this->job->title,
            'message' => 'A new job has been posted and needs approval.',
        ];
    }
}
