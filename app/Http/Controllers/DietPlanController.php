<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DietPlan;

class DietPlanController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->dietPlans;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $data['user_id'] = $request->user()->id;

        $plan = DietPlan::create($data);

        return response()->json($plan, 201);
    }

    public function show(Request $request, DietPlan $dietPlan)
    {
        if ($dietPlan->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $dietPlan;
    }

    public function update(Request $request, DietPlan $dietPlan)
    {
        if ($dietPlan->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'title' => 'string',
            'description' => 'nullable|string'
        ]);

        $dietPlan->update($data);

        return $dietPlan;
    }

    public function destroy(Request $request, DietPlan $dietPlan)
    {
        if ($dietPlan->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $dietPlan->delete();

        return response()->json([
            'message' => 'Plan deleted successfully'
        ]);
    }
}