<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Http\Resources\JobResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class JobController extends Controller
{
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        // استفاده از اسکوپ‌های هوشمند مادل (Week 8 Refactor)
        $query = Job::query()
            ->with('employer')
            ->search($request->query('search'))
            ->location($request->query('location'))
            ->employerFilter($request->query('employer_id'));

        // صنف‌بندی امن بر اساس لیست سفید
        $sortable = ['job_title', 'salary', 'created_at', 'deadline'];
        $sort = $request->query('sort', 'created_at');
        $direction = $request->query('direction', 'desc');

        if (!in_array($sort, $sortable)) $sort = 'created_at';
        if (!in_array($direction, ['asc', 'desc'])) $direction = 'desc';

        $query->orderBy($sort, $direction);

        // صفحه‌بندی هوشمند
        $perPage = (int) $request->query('per_page', 15);
        $perPage = min(100, max(1, $perPage));

        return JobResource::collection($query->paginate($perPage));
    }

    public function store(StoreJobRequest $request): JobResource
    {
        $employer = $request->user()->employer;

        if (!$employer) {
            abort(response()->json(['message' => 'You must have an employer profile to post jobs.'], 403));
        }

        $job = Job::create(array_merge(
            $request->validated(),
            ['employer_id' => $employer->employer_id]
        ));

        return new JobResource($job);
    }

    public function show(Job $job): JobResource
    {
        return new JobResource($job->load(['employer', 'applications']));
    }

    public function update(UpdateJobRequest $request, Job $job): JsonResponse
    {
        $user = $request->user();

        if (!$user->employer || $user->employer->employer_id !== $job->employer_id) {
            return response()->json([
                'message' => 'You are not allowed to do that',
                'errors'  => new \stdClass(),
            ], 403);
        }

        $job->update($request->validated());
        return response()->json($job, 200);
    }

    public function destroy(Request $request, Job $job): JsonResponse
    {
        $user = $request->user();

        if (!$user->employer || $user->employer->employer_id !== $job->employer_id) {
            return response()->json([
                'message' => 'You are not allowed to do that',
                'errors'  => new \stdClass(),
            ], 403);
        }

        $job->delete();
        return response()->json(null, 204);
    }
}
