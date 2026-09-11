<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use Illuminate\Http\JsonResponse;

class JobController extends Controller
{
    // نمایش لیست تمام شغل‌ها همراه با مشخصات شرکت کارفرما
    public function index(): JsonResponse
    {
        $jobs = Job::with('employer')->latest()->paginate(15);
        return response()->json($jobs, 200);
    }

    // ثبت یک آگهی شغلی جدید پس از اعتبارسنجی موفق
    public function store(StoreJobRequest $request): JsonResponse
    {
        $job = Job::create($request->validated());
        return response()->json($job, 201);
    }

    // نمایش یک شغل خاص بر اساس آیدی به همراه مشخصات کارفرما و درخواست‌های کار
    public function show(Job $job): JsonResponse
    {
        return response()->json($job->load(['employer', 'applications']), 200);
    }

    // ویرایش اطلاعات یک آگهی شغلی خاص
    public function update(UpdateJobRequest $request, Job $job): JsonResponse
    {
        $job->update($request->validated());
        return response()->json($job, 200);
    }

    // حذف کامل یک آگهی شغلی از سیستم
    public function destroy(Job $job): JsonResponse
    {
        $job->delete();
        return response()->json(null, 204);
    }
}
