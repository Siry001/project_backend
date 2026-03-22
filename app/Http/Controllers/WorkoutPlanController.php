<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkoutPlan;

class WorkoutPlanController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()
            ->workoutPlans()
            ->with('workouts')
            ->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'plan_text' => 'required|string'
        ]);

        $data['user_id'] = $request->user()->id;

        $plan = WorkoutPlan::create($data);

        return response()->json($plan, 201);
    }

    public function show(Request $request, WorkoutPlan $plan)
    {
        if ($plan->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $plan->load('workouts');
    }

    public function destroy(Request $request, WorkoutPlan $plan)
    {
        if ($plan->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $plan->delete();

        return response()->json([
            'message' => 'Plan deleted successfully'
        ]);
    }
}