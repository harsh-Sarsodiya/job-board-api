<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JobPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Job $job): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isEmployer();
    }

    public function update(User $user, Job $job): bool
    {
        return $user->id === $job->user_id;
    }

    public function delete(User $user, Job $job): bool
    {
        return $user->id === $job->user_id || $user->isAdmin();
    }

    public function updateStatus(User $user, Job $job): bool
    {
        return $user->isAdmin();
    }
}
