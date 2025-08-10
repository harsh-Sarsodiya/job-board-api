<?php

namespace App\Interfaces;

use App\Models\Job;
use Illuminate\Pagination\LengthAwarePaginator;

interface JobRepositoryInterface
{
    public function all(): LengthAwarePaginator;
    public function find(int $id): ?Job;
    public function create(array $data): Job;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function getActiveJobs(): LengthAwarePaginator;
    public function getEmployerJobs(int $employerId): LengthAwarePaginator;
    public function getPendingJobs(): LengthAwarePaginator;
    public function getExpiredJobs(): LengthAwarePaginator;
    public function updateStatus(int $id, string $status): bool;
}
