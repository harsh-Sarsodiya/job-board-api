<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationRequest;
use App\Http\Requests\ApplicationStatusRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\Job;
use App\Services\ApplicationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class ApplicationController extends Controller
{
    public function __construct(
        private ApplicationService $applicationService
    ) {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $applications = $request->user()->isEmployer()
            ? $this->applicationService->getJobApplications($request->job_id)
            : $this->applicationService->getUserApplications($request->user()->id);

        return ApplicationResource::collection($applications);
    }

    public function store(ApplicationRequest $request): JsonResponse
    {
        $job = Job::findOrFail($request->job_id);

        if ($job->status !== 'approved') {
            return response()->json([
                'message' => 'You can only apply to approved jobs'
            ], Response::HTTP_FORBIDDEN);
        }

        if ($job->expiration_date < now()) {
            return response()->json([
                'message' => 'This job has expired'
            ], Response::HTTP_FORBIDDEN);
        }

        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        if ($request->hasFile('resume')) {
            $data['resume_path'] = $request->file('resume')->store('resumes');
        }

        $application = $this->applicationService->createApplication($data);

        return response()->json([
            'message' => 'Application submitted successfully',
            'data' => new ApplicationResource($application),
        ], Response::HTTP_CREATED);
    }

    public function show(Application $application): JsonResponse
    {
        $this->authorize('view', $application);

        return response()->json([
            'data' => new ApplicationResource($application),
        ]);
    }

    public function updateStatus(Application $application, ApplicationStatusRequest $request): JsonResponse
    {
        $this->authorize('updateStatus', $application);

        $this->applicationService->updateApplicationStatus($application->id, $request->status);

        return response()->json([
            'message' => 'Application status updated successfully',
            'data' => new ApplicationResource($application->fresh()),
        ]);
    }

    public function destroy(Application $application): JsonResponse
    {
        $this->authorize('delete', $application);

        $this->applicationService->deleteApplication($application->id);

        return response()->json([
            'message' => 'Application deleted successfully',
        ]);
    }
}
