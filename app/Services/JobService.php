<?php

namespace App\Services;

use App\Interfaces\JobRepositoryInterface;
use App\Models\Job;
use Illuminate\Pagination\LengthAwarePaginator;

class JobService
{
    public function __construct(
        private JobRepositoryInterface $jobRepository
    ) {
    }

    public function getAllJobs(): LengthAwarePaginator
    {
        return $this->jobRepository->all();
    }

    public function getActiveJobs(): LengthAwarePaginator
    {
        return $this->jobRepository->getActiveJobs();
    }

    public function getJobById(int $id): ?Job
    {
        return $this->jobRepository->find($id);
    }

    public function createJob(array $data): Job
    {
        return $this->jobRepository->create($data);
    }

    public function updateJob(int $id, array $data): bool
    {
        return $this->jobRepository->update($id, $data);
    }

    public function deleteJob(int $id): bool
    {
        return $this->jobRepository->delete($id);
    }

    public function getEmployerJobs(int $employerId): LengthAwarePaginator
    {
        return $this->jobRepository->getEmployerJobs($employerId);
    }

    public function getPendingJobs(): LengthAwarePaginator
    {
        return $this->jobRepository->getPendingJobs();
    }

    public function updateJobStatus(int $id, string $status): bool
    {
        return $this->jobRepository->updateStatus($id, $status);
    }
}
