<?php

namespace App\Console\Commands;

use App\Models\Job;
use Illuminate\Console\Command;

class ExpireOldJobs extends Command
{
    protected $signature = 'jobs:expire';
    protected $description = 'Mark old jobs as expired';

    public function handle(): void
    {
        $count = Job::where('expiration_date', '<', now())
            ->where('status', '!=', 'rejected')
            ->update(['status' => 'rejected']);

        $this->info("Expired {$count} jobs.");
    }
}
