<?php

namespace App\Repositories;

use App\Interfaces\JobRepositoryInterface;
use App\Models\Job;
use Illuminate\Pagination\LengthAwarePaginator;

class JobRepository implements JobRepositoryInterface
{
    public function all(): LengthAwarePaginator
    {
        return Job::with('user')->paginate(10);
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

    public function getActiveJobs(): LengthAwarePaginator
    {
        return Job::active()->with('user')->paginate(10);
    }

    public function getEmployerJobs(int $employerId): LengthAwarePaginator
    {
        return Job::where('user_id', $employerId)->with('user')->paginate(10);
    }

    public function getPendingJobs(): LengthAwarePaginator
    {
        return Job::pending()->with('user')->paginate(10);
    }

    public function getExpiredJobs(): LengthAwarePaginator
    {
        return Job::expired()->with('user')->paginate(10);
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
