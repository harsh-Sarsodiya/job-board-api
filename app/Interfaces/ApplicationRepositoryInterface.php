<?php

namespace App\Interfaces;

use App\Models\Application;
use Illuminate\Pagination\LengthAwarePaginator;

interface ApplicationRepositoryInterface
{
    public function all(): LengthAwarePaginator;
    public function find(int $id): ?Application;
    public function create(array $data): Application;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function getJobApplications(int $jobId): LengthAwarePaginator;
    public function getUserApplications(int $userId): LengthAwarePaginator;
    public function updateApplicationStatus(int $id, string $status): bool;
}
