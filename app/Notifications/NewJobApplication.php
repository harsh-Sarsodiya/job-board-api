<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewJobApplication extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Application $application)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Application for Your Job')
            ->line('You have received a new application for your job posting.')
            ->line('Job Title: ' . $this->application->job->title)
            ->line('Applicant: ' . $this->application->user->name)
            ->action('View Application', url('/employer/applications/' . $this->application->id))
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'job_title' => $this->application->job->title,
            'applicant_name' => $this->application->user->name,
            'message' => 'You have received a new application for your job posting.',
        ];
    }
}
