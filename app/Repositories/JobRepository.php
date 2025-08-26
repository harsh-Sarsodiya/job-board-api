<?php

namespace App\Repositories;

use App\Interfaces\JobRepositoryInterface;
use App\Models\Job;
use Illuminate\Contracts\Pagination\Paginator;

class JobRepository implements JobRepositoryInterface
{
    public function all(int $perPage = 10): Paginator
    {
        return Job::with('user')->paginate($perPage);
    }

    public function find(int $id): ?Job
    {
        return Job::with('user')->find($id);
    }

    public function create(array $data): Job
    {
        return Job::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $job = Job::find($id);
        if (!$job) {
            return false;
        }
        return $job->update($data);
    }

    public function delete(int $id): bool
    {
        return Job::destroy($id) > 0;
    }

    public function getActiveJobs(int $perPage = 10): Paginator
    {
        return Job::active()->with('user')->paginate($perPage);
    }

    public function getEmployerJobs(int $employerId, int $perPage = 10): Paginator
    {
        return Job::where('user_id', $employerId)
            ->with('user')
            ->paginate($perPage);
    }

    public function getPendingJobs(int $perPage = 10): Paginator
    {
        return Job::pending()->with('user')->paginate($perPage);
    }

    public function getExpiredJobs(int $perPage = 10): Paginator
    {
        return Job::expired()->with('user')->paginate($perPage);
    }

    public function updateStatus(int $id, string $status): bool
    {
        $job = Job::find($id);
        if (!$job) {
            return false;
        }
        $job->status = $status;
        return $job->save();
    }
}
