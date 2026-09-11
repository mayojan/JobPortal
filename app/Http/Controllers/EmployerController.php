<?php

namespace App\Http\Controllers;
use App\Http\Requests\UpdateEmployerRequest;
use App\Http\Requests\StoreEmployerRequest;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return \App\Models\Employer::with('jobs')->latest()->paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployerRequest $request)
    {
        // دیتای تایید شده را میگیرد و کارفرما را میسازد
        $employer = \App\Models\Employer::create($request->validated());
        
        //پاسخ را با کد ظ ظ store ۲ روان میکند یعنی ساخته شد
        return response()->json($employer, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\Employer $employer)
    {
        return $employer->load('jobs');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployerRequest $request, \App\Models\Employer $employer)
    {
        // دیتای تایید شده را برمی‌دارد و کارفرما را ویرایش می‌کند
        $employer->update($request->validated());

        // کارفرمای آپدیت شده را با کد ۲۰۰ OK پس می‌فرستد
        return response()->json($employer, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\Employer $employer)
    {
        // کارفرما را از دیتابیس پاک می‌کند
        $employer->delete();

        // پاسخ خالی با وضعیت ۲۰۴ No Content می‌فرستد که یعنی عملیات حذف موفق بود
        return response()->json(null, 204);
    }
}
