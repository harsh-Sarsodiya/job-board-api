<?php

namespace App\Services;

use App\Interfaces\ApplicationRepositoryInterface;
use App\Models\Application;
use Illuminate\Contracts\Pagination\Paginator;

class ApplicationService
{
    public function __construct(
        private ApplicationRepositoryInterface $applicationRepository
    ) {
    }

    public function getAllApplications(int $perPage = 10): Paginator
    {
        return $this->applicationRepository->all($perPage);
    }

    public function getApplicationById(int $id): ?Application
    {
        return $this->applicationRepository->find($id);
    }

    public function createApplication(array $data): Application
    {
        return $this->applicationRepository->create($data);
    }

    public function updateApplication(int $id, array $data): bool
    {
        return $this->applicationRepository->update($id, $data);
    }

    public function deleteApplication(int $id): bool
    {
        return $this->applicationRepository->delete($id);
    }

    public function getJobApplications(int $jobId, int $perPage = 10): Paginator
    {
        return $this->applicationRepository->getJobApplications($jobId, $perPage);
    }

    public function getUserApplications(int $userId, int $perPage = 10): Paginator
    {
        return $this->applicationRepository->getUserApplications($userId, $perPage);
    }

    public function updateApplicationStatus(int $id, string $status): bool
    {
        return $this->applicationRepository->updateApplicationStatus($id, $status);
    }
}
