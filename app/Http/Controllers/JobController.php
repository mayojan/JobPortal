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
        // شروع کوئری و لود پیش‌فرض رابطه کارفرما
        $query = \App\Models\Job::query()->with('employer');

        // --- فیلتر کردن (Filtering) ---
        // فیلتر بر اساس موقعیت مکانی (مثلاً کابل یا مزار)
        $query->when($request->query('location'), function ($q, $location) {
            $q->where('location', $location);
        });

        // فیلتر بر اساس آیدی کارفرما (شغل‌های یک شرکت خاص)
        $query->when($request->query('employer_id'), function ($q, $employerId) {
            $q->where('employer_id', $employerId);

        });

        // --- جستجو هوشمند (Searching) ---
        // جستجو در عنوان شغل یا توضیحات آن
        $query->when($request->query('search'), function ($q, $term) {
            $q->where(function ($inner) use ($term) {
                $inner->where('job_title', 'like', "%{$term}%")->orWhere('description', 'like', "%{$term}%");
            });
        });

        // --- صنف‌بندی امن و لیست سفید (Sorting Whitelisted) ---
        // لیست فیلدهایی که کاربر اجازه دارد بر اساس آن‌ها صنف‌بندی کند 
        $sortable = ['job_title', 'salary', 'created_at', 'deadline'];
        
        $sort = $request->query('sort', 'created_at');
        $direction = $request->query('direction', 'desc');

        // اگر ستون ارسالی کاربر در لیست سفید نبود، به حالت پیش‌فرض (created_at) برمی‌گردد
        if (!in_array($sort, $sortable)) $sort = 'created_at';
        if (!in_array($direction, ['asc', 'desc'])) $direction = 'desc';

        $query->orderBy($sort, $direction);

        // --- صفحه‌بندی هوشمند همراه با سقف مجاز (Pagination Control) ---
        $perPage = (int) $request->query('per_page', 15);
        $perPage = min(100, max(1, $perPage)); // سقف مجاز حداکثر ۱۰۰ آیتم 
        //  بازگرداندن دیتا در پوشش ریسورس
        return JobResource::collection($query->paginate($perPage));
}

    public function store(\App\Http\Requests\StoreJobRequest $request)
    {
        // پیدا کردن کارفرمای متعلق به کاربر لاگین شده
        $employer = $request->user()->employer;

        if (!$employer) {
            return response()->json(['message' => 'You must have an employer profile to post jobs.'], 403);
        }

        // ساخت شغل جدید همراه با آیدی کارفرمای واقعی لاگین شده
        $job = \App\Models\Job::create(array_merge(
            $request->validated(),
            ['employer_id' => $employer->employer_id]
        ));

        return new \App\Http\Resources\JobResource($job);
    }


    public function show(\App\Models\Job $job): JobResource
    {
        return new JobResource($job->load(['employer', 'applications']));
    }

        // ویرایش اطلاعات یک آگهی شغلی خاص همراه با بررسی سطح دسترسی
    public function update(UpdateJobRequest $request, Job $job): JsonResponse
    {
        $user = $request->user();

        // بررسی مالکیت شغل
        if (!$user->employer || $user->employer->employer_id !== $job->employer_id) {
            return response()->json([
                'message' => 'You are not allowed to do that',
                'errors'  => new \stdClass(),
            ], 403);
        }

        $job->update($request->validated());
        return response()->json($job, 200);
    }

    // حذف کامل یک آگهی شغلی از سیستم همراه با بررسی سطح دسترسی
    public function destroy(Request $request, Job $job): JsonResponse
    {
        $user = $request->user();

        // بررسی مالکیت شغل
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
