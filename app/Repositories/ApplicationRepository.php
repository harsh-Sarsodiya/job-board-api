<?php

namespace App\Repositories;

use App\Interfaces\ApplicationRepositoryInterface;
use App\Models\Application;
use Illuminate\Pagination\LengthAwarePaginator;

class ApplicationRepository implements ApplicationRepositoryInterface
{
    public function all(): LengthAwarePaginator
    {
        return Application::with(['job', 'user'])->paginate(10);
    }

    public function find(int $id): ?Application
    {
        return Application::with(['job', 'user'])->find($id);
    }

    public function create(array $data): Application
    {
        return Application::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $application = Application::find($id);
        if (!$application) {
            return false;
        }
        return $application->update($data);
    }

    public function delete(int $id): bool
    {
        return Application::destroy($id) > 0;
    }

    public function getJobApplications(int $jobId): LengthAwarePaginator
    {
        return Application::where('job_id', $jobId)
            ->with(['job', 'user'])
            ->paginate(10);
    }

    public function getUserApplications(int $userId): LengthAwarePaginator
    {
        return Application::where('user_id', $userId)
            ->with(['job', 'user'])
            ->paginate(10);
    }

    public function updateApplicationStatus(int $id, string $status): bool
    {
        $application = Application::find($id);
        if (!$application) {
            return false;
        }
        $application->status = $status;
        return $application->save();
    }
}
