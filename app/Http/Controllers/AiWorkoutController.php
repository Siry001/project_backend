<?php

namespace App\Http\Controllers;

use App\Models\WorkoutPlan;
use App\Services\AiWorkoutService;
use Illuminate\Http\Request;

class AiWorkoutController extends Controller
{
    protected $aiWorkoutService;

    public function __construct(AiWorkoutService $aiWorkoutService)
    {
        $this->aiWorkoutService = $aiWorkoutService;
    }

    public function generate(Request $request)
    {
        $request->validate([
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'age' => 'required|integer',
        ]);

        $planText = $this->aiWorkoutService->generateWorkout(
            $request->height,
            $request->weight,
            $request->age
        );

        $workoutPlan = WorkoutPlan::create([
            'user_id' => $request->user()->id,
            'plan_text' => $planText,
        ]);

        return response()->json([
            'message' => 'Workout plan generated successfully',
            'workout_plan' => $workoutPlan
        ], 201);
    }
}
