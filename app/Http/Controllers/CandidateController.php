<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Http\Requests\StoreCandidateRequest;
use Illuminate\Http\JsonResponse;

class CandidateController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Candidate::with(['user', 'cv'])->latest()->paginate(15), 200);
    }

    public function store(StoreCandidateRequest $request): JsonResponse
    {
        $candidate = Candidate::create($request->validated());
        return response()->json($candidate, 201);
    }

    public function show(Candidate $candidate): JsonResponse
    {
        return response()->json($candidate->load(['user', 'cv', 'applications']), 200);
    }

    public function update(\Illuminate\Http\Request $request, Candidate $candidate): JsonResponse
    {
        $candidate->update($request->all());
        return response()->json($candidate, 200);
    }

    public function destroy(Candidate $candidate): JsonResponse
    {
        $candidate->delete();
        return response()->json(null, 204);
    }
}
