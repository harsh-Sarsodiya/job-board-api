<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_candidate_can_apply_to_job(): void
    {
        Notification::fake();

        $employer = User::factory()->create(['role' => 'employer']);
        $candidate = User::factory()->create(['role' => 'candidate']);

        $job = Job::factory()->create([
            'user_id' => $employer->id,
            'status' => 'approved',
            'expiration_date' => now()->addWeek(),
        ]);

        $token = JWTAuth::fromUser($candidate);

        $response = $this->postJson('/api/v1/applications', [
            'job_id' => $job->id,
            'message' => 'I am interested in this position.',
        ], [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Application submitted successfully',
                'data' => [
                    'status' => 'pending',
                ],
            ]);

        $this->assertDatabaseHas('applications', [
            'job_id' => $job->id,
            'user_id' => $candidate->id,
            'status' => 'pending',
        ]);

        Notification::assertSentTo(
            [$employer],
            \App\Notifications\NewJobApplication::class
        );
    }

    public function test_employer_can_update_application_status(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $candidate = User::factory()->create(['role' => 'candidate']);

        $job = Job::factory()->create([
            'user_id' => $employer->id,
            'status' => 'approved',
        ]);

        $application = Application::factory()->create([
            'job_id' => $job->id,
            'user_id' => $candidate->id,
            'status' => 'pending',
        ]);

        $token = JWTAuth::fromUser($employer);

        $response = $this->postJson("/api/v1/applications/{$application->id}/status", [
            'status' => 'accepted',
        ], [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Application status updated successfully',
                'data' => [
                    'status' => 'accepted',
                ],
            ]);

        $this->assertDatabaseHas('applications', [
            'id' => $application->id,
            'status' => 'accepted',
        ]);
    }
}
