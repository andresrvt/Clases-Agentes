<?php

namespace App\Http\Controllers;

use App\Models\IaConfiguration;
use Illuminate\Http\JsonResponse;

class IaConfigurationController extends Controller
{
    public function index(): JsonResponse
    {
        $configs = IaConfiguration::all();

        return response()->json($configs);
    }

    public function show(): JsonResponse
    {
        $configs = IaConfiguration::all();

        return response()->json($configs);
    }

    public function update(): JsonResponse
    {
        $data = request()->validate([
            'prompt' => 'nullable|string',
            'model' => 'nullable|string',
            'job' => 'nullable|string',
        ]);

        $config = IaConfiguration::first();

        if ($config) {
            $config->update($data);
        } else {
            $config = IaConfiguration::create($data);
        }

        return response()->json([
            'id' => $config->id,
            'prompt' => $config->prompt,
            'model' => $config->model,
            'job' => $config->job,
        ]);
    }

    public function store(): JsonResponse
    {
        $data = request()->validate([
            'prompt' => 'nullable|string',
            'model' => 'nullable|string',
            'job' => 'nullable|string',
        ]);

        $config = IaConfiguration::create($data);

        return response()->json([
            'id' => $config->id,
            'prompt' => $config->prompt,
            'model' => $config->model,
            'job' => $config->job,
        ], 201);
    }

    public function destroy(int $id): JsonResponse
    {
        $config = IaConfiguration::findOrFail($id);
        $config->delete();

        return response()->json(null, 204);
    }
}