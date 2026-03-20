<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkoutPlan;

class WorkoutPlanController extends Controller
{
    public function __construct()
    {
       $this->authorizeResource(WorkoutPlan::class, 'Plan');
    }

    // ================= INDEX =================
    public function index(Request $request)
    {
        return $request->user()
            ->workoutPlans()
            ->with('workouts')
            ->latest()
            ->paginate(10);
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $data = $request->validate([
            'plan_text' => 'required|string|max:5000'
        ]);

        // 👇 دي الصح 100%
        $plan = $request->user()->workoutPlans()->create($data);

        return response()->json($plan, 201);
    }

    // ================= SHOW =================
    public function show(WorkoutPlan $workoutPlan)
    {
        dd($workoutPlan);
    }

    // ================= UPDATE =================
    public function update(Request $request, WorkoutPlan $workoutPlan)
    {
        $data = $request->validate([
            'plan_text' => 'required|string|max:5000'
        ]);

        $workoutPlan->update($data);

        return response()->json($workoutPlan);
    }

    // ================= DELETE =================
    public function destroy(WorkoutPlan $workoutPlan)
    {
        $workoutPlan->delete();

        return response()->json([
            'message' => 'Plan deleted successfully'
        ]);
    }
}