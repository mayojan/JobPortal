<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Http\Requests\StoreApplicationRequest;
use Illuminate\Http\JsonResponse;

class ApplicationController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Application::with(['job', 'candidate'])->latest()->paginate(15), 200);
    }

    public function store(StoreApplicationRequest $request): JsonResponse
    {
        $application = Application::create($request->validated());
        return response()->json($application, 201);
    }

    public function show(Application $application): JsonResponse
    {
        return response()->json($application->load(['job', 'candidate']), 200);
    }

    public function update(\Illuminate\Http\Request $request, Application $application): JsonResponse
    {
        $application->update($request->all());
        return response()->json($application, 200);
    }

    public function destroy(Application $application): JsonResponse
    {
        $application->delete();
        return response()->json(null, 204);
    }
}
