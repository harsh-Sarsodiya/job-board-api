<?php

namespace App\Services;

use App\Interfaces\JobRepositoryInterface;
use App\Models\Job;
use Illuminate\Contracts\Pagination\Paginator;

class JobService
{
    public function __construct(
        private JobRepositoryInterface $jobRepository
    ) {
    }

    public function getAllJobs(int $perPage = 10): Paginator
    {
        return $this->jobRepository->all($perPage);
    }

    public function getActiveJobs(int $perPage = 10): Paginator
    {
        return $this->jobRepository->getActiveJobs($perPage);
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

    public function getEmployerJobs(int $employerId, int $perPage = 10): Paginator
    {
        return $this->jobRepository->getEmployerJobs($employerId, $perPage);
    }

    public function getPendingJobs(int $perPage = 10): Paginator
    {
        return $this->jobRepository->getPendingJobs($perPage);
    }

    public function updateJobStatus(int $id, string $status): bool
    {
        return $this->jobRepository->updateStatus($id, $status);
    }
}
