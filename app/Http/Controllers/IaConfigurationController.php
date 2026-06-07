<?php

namespace App\Http\Controllers;

use App\Models\IaConfiguration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IaConfigurationController extends Controller
{
    public function index(): JsonResponse
    {
        $configs = IaConfiguration::all();
        return response()->json($configs);
    }

    public function show(int $id): JsonResponse
    {
        $config = IaConfiguration::findOrFail($id);
        return response()->json($config);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $data = $request->validate([
            'prompt' => 'nullable|string',
            'model' => 'nullable|string',
            'process_name' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
        ]);

        $config = IaConfiguration::findOrFail($id);
        $config->update($data);

        return response()->json($config);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'prompt' => 'nullable|string',
            'model' => 'nullable|string',
            'process_name' => 'required|string',
            'status' => 'nullable|in:active,inactive',
        ]);

        $config = IaConfiguration::create($data);

        return response()->json($config, 201);
    }

    public function destroy(int $id): JsonResponse
    {
        $config = IaConfiguration::findOrFail($id);
        $config->delete();

        return response()->json(null, 204);
    }
}