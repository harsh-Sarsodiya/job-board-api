<?php

namespace App\Interfaces;

use App\Models\Job;
use Illuminate\Contracts\Pagination\Paginator;

interface JobRepositoryInterface
{
    public function all(int $perPage = 10): Paginator;
    public function find(int $id): ?Job;
    public function create(array $data): Job;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function getActiveJobs(int $perPage = 10): Paginator;
    public function getEmployerJobs(int $employerId, int $perPage = 10): Paginator;
    public function getPendingJobs(int $perPage = 10): Paginator;
    public function getExpiredJobs(int $perPage = 10): Paginator;
    public function updateStatus(int $id, string $status): bool;
}
