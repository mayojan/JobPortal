<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobResource;
use App\Models\Job;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use Illuminate\Http\Request;

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

    public function store(\App\Http\Requests\StoreJobRequest $request): JobResource
    {
        $job = \App\Models\Job::created($request->calidated());
        return new JobResource($job);
    }

    public function show(\App\Models\Job $job): JobResource
    {
        return new JobResource($job->load(['employer', 'applications']));
    }

    // ویرایش اطلاعات یک آگهی شغلی خاص
    public function update(\App\Http\Requests\UpdateJobRequest $request, \App\Models\Job $job): JobResource
    {
        $job->update($request->validated());
        return new JobResource($job);
    }

    // حذف کامل یک آگهی شغلی از سیستم
    public function destroy(\App\Models\Job $job): \Illuminate\Http\JsonResponse
    {
        $job->delete();
        return response()->json(null, 204);
    }
}
