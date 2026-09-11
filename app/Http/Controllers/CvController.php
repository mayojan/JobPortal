<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use App\Http\Requests\StoreCvRequest;
use Illuminate\Http\JsonResponse;

class CvController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Cv::with('candidate')->latest()->paginate(15), 200);
    }

    public function store(StoreCvRequest $request): JsonResponse
    {
        $cv = Cv::create($request->validated());
        return response()->json($cv, 201);
    }

    public function show(Cv $cv): JsonResponse
    {
        return response()->json($cv->load('candidate'), 200);
    }

    public function update(\Illuminate\Http\Request $request, Cv $cv): JsonResponse
    {
        $cv->update($request->all());
        return response()->json($cv, 200);
    }

    public function destroy(Cv $cv): JsonResponse
    {
        $cv->delete();
        return response()->json(null, 204);
    }
}
