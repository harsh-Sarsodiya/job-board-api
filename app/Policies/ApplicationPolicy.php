<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ApplicationPolicy
{
    public function view(User $user, Application $application): bool
    {
        return $user->id === $application->user_id ||
               $user->id === $application->job->user_id;
    }

    public function create(User $user): bool
    {
        return $user->isCandidate();
    }

    public function updateStatus(User $user, Application $application): bool
    {
        return $user->id === $application->job->user_id;
    }

    public function delete(User $user, Application $application): bool
    {
        return $user->id === $application->user_id ||
               $user->id === $application->job->user_id;
    }
}
