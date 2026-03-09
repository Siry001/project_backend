<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DietPlan;

class DietPlanController extends Controller
{
    public function index(Request $request)
    {
        return DietPlan::where('user_id', $request->user()->id)->get();
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

    public function show(DietPlan $dietPlan)
    {
        return $dietPlan;
    }

    public function update(Request $request, DietPlan $dietPlan)
    {
        $dietPlan->update($request->all());
        return $dietPlan;
    }

    public function destroy(DietPlan $dietPlan)
    {
        $dietPlan->delete();
        return response()->json(['message' => 'Deleted']);
    }
}