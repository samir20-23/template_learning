<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AboutController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(About::all());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        $about = About::create($data);
        return response()->json($about, 201);
    }

    public function show(About $about): JsonResponse
    {
        return response()->json($about);
    }

    public function update(Request $request, About $about): JsonResponse
    {
        $data = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
        ]);
        $about->update($data);
        return response()->json($about);
    }

    public function destroy(About $about): JsonResponse
    {
        $about->delete();
        return response()->json(null, 204);
    }
}
