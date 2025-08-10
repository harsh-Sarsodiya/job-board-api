<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class JobTest extends TestCase
{
    use RefreshDatabase;

    public function test_employer_can_create_job(): void
    {
        Notification::fake();

        $employer = User::factory()->create(['role' => 'employer']);

        $response = $this->actingAs($employer)
            ->postJson('/api/v1/jobs', [
                'title' => 'Software Engineer',
                'description' => 'We are looking for a skilled software engineer.',
                'type' => 'full-time',
                'salary' => 80000,
                'expiration_date' => now()->addMonth()->format('Y-m-d'),
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Job created successfully',
                'data' => [
                    'title' => 'Software Engineer',
                    'status' => 'pending',
                ],
            ]);

        $this->assertDatabaseHas('jobs', [
            'title' => 'Software Engineer',
            'user_id' => $employer->id,
            'status' => 'pending',
        ]);

        Notification::assertSentTo(
            User::where('role', 'admin')->get(),
            \App\Notifications\NewJobPosted::class
        );
    }

    public function test_admin_can_approve_job(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $employer = User::factory()->create(['role' => 'employer']);

        $job = Job::factory()->create([
            'user_id' => $employer->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)
            ->postJson("/api/v1/jobs/{$job->id}/status", [
                'status' => 'approved',
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Job status updated successfully',
                'data' => [
                    'status' => 'approved',
                ],
            ]);

        $this->assertDatabaseHas('jobs', [
            'id' => $job->id,
            'status' => 'approved',
        ]);
    }

    public function test_candidate_cannot_create_job(): void
    {
        $candidate = User::factory()->create(['role' => 'candidate']);

        $response = $this->actingAs($candidate)
            ->postJson('/api/v1/jobs', [
                'title' => 'Software Engineer',
                'description' => 'We are looking for a skilled software engineer.',
                'type' => 'full-time',
                'salary' => 80000,
                'expiration_date' => now()->addMonth()->format('Y-m-d'),
            ]);

        $response->assertStatus(403);
    }
}
