<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobRequest;
use App\Http\Requests\JobStatusRequest;
use App\Http\Resources\JobResource;
use App\Models\Job;
use App\Services\JobService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class JobController extends Controller
{
    public function __construct(
        private JobService $jobService
    ) {
    }

    public function index(): AnonymousResourceCollection
    {
        $jobs = $this->jobService->getActiveJobs();
        return JobResource::collection($jobs);
    }

    public function store(JobRequest $request): JsonResponse
    {
        $job = $this->jobService->createJob(array_merge(
            $request->validated(),
            ['user_id' => $request->user()->id]
        ));

        return response()->json([
            'message' => 'Job created successfully',
            'data' => new JobResource($job),
        ], Response::HTTP_CREATED);
    }

    public function show(Job $job): JsonResponse
    {
        return response()->json([
            'data' => new JobResource($job),
        ]);
    }

    public function update(JobRequest $request, Job $job): JsonResponse
    {
        $this->authorize('update', $job);

        $this->jobService->updateJob($job->id, $request->validated());

        return response()->json([
            'message' => 'Job updated successfully',
            'data' => new JobResource($job->fresh()),
        ]);
    }

    public function destroy(Job $job): JsonResponse
    {
        $this->authorize('delete', $job);

        $this->jobService->deleteJob($job->id);

        return response()->json([
            'message' => 'Job deleted successfully',
        ]);
    }

    public function myJobs(Request $request): AnonymousResourceCollection
    {
        $jobs = $this->jobService->getEmployerJobs($request->user()->id);
        return JobResource::collection($jobs);
    }

    public function pendingJobs(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Job::class);

        $jobs = $this->jobService->getPendingJobs();
        return JobResource::collection($jobs);
    }

    public function updateStatus(Job $job, JobStatusRequest $request): JsonResponse
    {
        $this->authorize('updateStatus', $job);

        $this->jobService->updateJobStatus($job->id, $request->status);

        return response()->json([
            'message' => 'Job status updated successfully',
            'data' => new JobResource($job->fresh()),
        ]);
    }
}
