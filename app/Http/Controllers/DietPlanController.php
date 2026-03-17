<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DietPlan;
use App\Models\Diet;

class DietPlanController extends Controller
{
    public function index(Request $request)
    {
        $plans = DietPlan::where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json($plans);
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

    public function show(Request $request, $id)
    {
        $plan = DietPlan::findOrFail($id);

        if ($plan->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $diets = Diet::where('diet_plan_id', $id)->get();

        $grouped = [];

        foreach ($diets as $diet) {
            $meal = $diet->meal ?? 'Unknown';

            if (!isset($grouped[$meal])) {
                $grouped[$meal] = [
                    'foods' => [],
                    'total_calories' => 0
                ];
            }

            $grouped[$meal]['foods'][] = [
                'name' => $diet->name,
                'calories' => $diet->calories
            ];

            $grouped[$meal]['total_calories'] += $diet->calories;
        }

        return response()->json([
            'plan' => $plan,
            'diet' => $grouped
        ]);
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

        return response()->json($dietPlan);
    }

    public function destroy(Request $request, DietPlan $dietPlan)
    {
        if ($dietPlan->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // 🔥 delete related diets
        Diet::where('diet_plan_id', $dietPlan->id)->delete();

        $dietPlan->delete();

        return response()->json([
            'message' => 'Plan deleted successfully'
        ]);
    }
}