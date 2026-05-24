<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IaConfigurationController;

Route::get('/ia-configuration', [IaConfigurationController::class, 'index']);
Route::post('/ia-configuration', [IaConfigurationController::class, 'store']);
Route::put('/ia-configuration', [IaConfigurationController::class, 'update']);
Route::delete('/ia-configuration/{id}', [IaConfigurationController::class, 'destroy']);