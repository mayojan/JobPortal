<?php

namespace App\Http\Controllers;
use App\Http\Resources\EmployerResource;
use App\Http\Requests\UpdateEmployerRequest;
use App\Http\Requests\StoreEmployerRequest;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return EmployerResource::collection(\App\Models\Employer::with('jobs')->latest()->paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\App\Http\Requests\StoreEmployerRequest $request): EmployerResource
    {
        $employer = \App\Models\Employer::create($request->validated());
        return new EmployerResource($employer); // پوشش Resource
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\Employer $employer): EmployerResource
    {
        return new EmployerResource($employer->load('jobs'));
    }
    
    public function update(\App\Http\Requests\UpdateEmployerRequest $request, \App\Models\Employer $employer): EmployerResource
    {
        // دیتای تایید شده را برمی‌دارد و کارفرما را ویرایش می‌کند
        $employer->update($request->validated());

        // کارفرمای آپدیت شده را با کد ۲۰۰ OK پس می‌فرستد
        return new EmployerResource($employer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\Employer $employer): \Illuminate\Http\JsonResponse
    {
        // کارفرما را از دیتابیس پاک می‌کند
        $employer->delete();

        // پاسخ خالی با وضعیت ۲۰۴ No Content می‌فرستد که یعنی عملیات حذف موفق بود
        return response()->json(null, 204);
    }
}
