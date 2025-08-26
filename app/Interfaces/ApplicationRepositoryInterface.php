<?php

namespace App\Interfaces;

use App\Models\Application;
use Illuminate\Contracts\Pagination\Paginator;

interface ApplicationRepositoryInterface
{
    public function all(int $perPage = 10): Paginator;
    public function find(int $id): ?Application;
    public function create(array $data): Application;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function getJobApplications(int $jobId, int $perPage = 10): Paginator;
    public function getUserApplications(int $userId, int $perPage = 10): Paginator;
    public function updateApplicationStatus(int $id, string $status): bool;
}
