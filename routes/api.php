<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\WorkoutPlanController;
use App\Http\Controllers\WorkoutLogController;
use App\Http\Controllers\DietPlanController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Routes (Sanctum)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Profile
    Route::get('/profile', function (Request $request) {
        return $request->user();
    });

    /*
    |--------------------------------------------------------------------------
    | Workouts
    |--------------------------------------------------------------------------
    */

    Route::apiResource('workouts', WorkoutController::class);

    /*
    |--------------------------------------------------------------------------
    | Workout Plans
    |--------------------------------------------------------------------------
    */

    Route::apiResource('plans', WorkoutPlanController::class);

    /*
    |--------------------------------------------------------------------------
    | Workout Logs
    |--------------------------------------------------------------------------
    */

    Route::apiResource('logs', WorkoutLogController::class);

    /*
    |--------------------------------------------------------------------------
    | Diet Plans
    |--------------------------------------------------------------------------
    */

    Route::apiResource('diet-plans', DietPlanController::class);

    /*
    |--------------------------------------------------------------------------
    | Workout Progress
    |--------------------------------------------------------------------------
    */

    Route::get('/workouts/{id}/progress', [WorkoutController::class, 'progress']);
});