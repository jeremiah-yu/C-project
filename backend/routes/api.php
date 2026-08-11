<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MonitoringController;
use App\Http\Controllers\Api\StudentController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1');

Route::middleware('auth:sanctum')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    Route::middleware('role.monitoring')->group(function (): void {
        Route::get('/monitoring/early-warnings', [MonitoringController::class, 'earlyWarnings']);
        Route::get('/monitoring/my-risk', [MonitoringController::class, 'myRisk']);
        Route::post('/monitoring/students/{student}/support-plan', [MonitoringController::class, 'supportPlan']);
        Route::get('/monitoring/study-plans', [MonitoringController::class, 'studyPlans']);
        Route::get('/monitoring/students/{student}/study-plan', [MonitoringController::class, 'studyPlan']);
        Route::get('/monitoring/adviser-alerts', [MonitoringController::class, 'adviserAlerts']);
        Route::get('/monitoring/ai-status', [MonitoringController::class, 'aiStatus']);
        Route::post('/monitoring/students/{student}/ai-help', [MonitoringController::class, 'aiHelp']);
    });

    Route::middleware('role.registrar-or-admin')->group(function (): void {
        Route::get('/students', [StudentController::class, 'index']);
        Route::get('/students/{student}', [StudentController::class, 'show']);
        Route::get('/students/{student}/documents', [StudentController::class, 'documents']);
        Route::patch('/students/{student}', [StudentController::class, 'update']);
    });
});
