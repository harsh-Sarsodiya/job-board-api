<?php

namespace Tests\Unit;

use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobTest extends TestCase
{
    use RefreshDatabase;

    public function test_active_scope(): void
    {
        $user = User::factory()->create(['role' => 'employer']);

        $activeJob = Job::factory()->create([
            'user_id' => $user->id,
            'status' => 'approved',
            'expiration_date' => now()->addWeek(),
        ]);

        $expiredJob = Job::factory()->create([
            'user_id' => $user->id,
            'status' => 'approved',
            'expiration_date' => now()->subWeek(),
        ]);

        $pendingJob = Job::factory()->create([
            'user_id' => $user->id,
            'status' => 'pending',
            'expiration_date' => now()->addWeek(),
        ]);

        $rejectedJob = Job::factory()->create([
            'user_id' => $user->id,
            'status' => 'rejected',
            'expiration_date' => now()->addWeek(),
        ]);

        $activeJobs = Job::active()->get();

        $this->assertTrue($activeJobs->contains($activeJob));
        $this->assertFalse($activeJobs->contains($expiredJob));
        $this->assertFalse($activeJobs->contains($pendingJob));
        $this->assertFalse($activeJobs->contains($rejectedJob));
    }
}
