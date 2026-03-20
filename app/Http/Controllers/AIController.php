<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AIService;
use App\Models\WorkoutPlan;
use App\Models\Workout;
use App\Models\DietPlan;
use App\Models\Diet;
use App\Models\AIDiet;


class AIController extends Controller
{
    protected $ai;

    public function __construct(AIService $ai)
    {
        $this->ai = $ai;
    }

    public function generateWorkout(Request $request)
    {
        $data = $request->validate([
            'goal' => 'required|string',
            'level' => 'required|string',
            'days' => 'required|integer'
        ]);

        $result = $this->ai->generateWorkout(
            $data['goal'],
            $data['level'],
            $data['days']
        );

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'error' => $result['error']
            ], 400);
        }

        $user = $request->user();
        $planData = $result['data']['plan'] ?? [];

        if (empty($planData)) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid plan data'
            ], 400);
        }

        $plan = WorkoutPlan::create([
            'user_id' => $user->id,
            'plan_text' => $data['goal'] . ' Plan - ' . now()->format('d/m H:i')
        ]);

        foreach ($planData as $dayData) {
            if (!isset($dayData['day'], $dayData['exercises'])) continue;

            foreach ($dayData['exercises'] as $exercise) {
                if (!isset($exercise['name'])) continue;

                Workout::create([
                    'user_id' => $user->id,
                    'name' => $exercise['name'],
                    'description' => $exercise['name'],
                    'day' => $dayData['day'],
                    'duration' => 60,
                    'workout_plan_id' => $plan->id
                ]);
            }
        }

        $workouts = Workout::where('workout_plan_id', $plan->id)->get();

        $grouped = [];

        foreach ($workouts as $workout) {
            $day = $workout->day ?? 'Unknown';

            if (!isset($grouped[$day])) {
                $grouped[$day] = [];
            }

            $grouped[$day][] = [
                'name' => $workout->name,
                'duration' => $workout->duration
            ];
        }

        return response()->json([
            'success' => true,
            'plan_id' => $plan->id,
            'plan' => $grouped
        ]);
    }

    public function generateDiet(Request $request)
    {
        $data = $request->validate([
            'goal' => 'required|string',
            'weight' => 'required|numeric',
            'meals' => 'required|integer'
        ]);

        $result = $this->ai->generateDiet(
            $data['goal'],
            $data['weight'],
            $data['meals']
        );

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'error' => $result['error']
            ], 400);
        }

        $user = $request->user();
        $dietData = $result['data']['diet'] ?? [];

        if (empty($dietData)) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid diet data'
            ], 400);
        }

        // ✅ unique title
        $plan = DietPlan::create([
            'user_id' => $user->id,
            'title' => $data['goal'] . ' Diet - ' . now()->format('d/m H:i'),
            'description' => 'AI Generated Diet'
        ]);

        foreach ($dietData as $mealData) {
            if (!isset($mealData['meal'], $mealData['foods'])) continue;

            foreach ($mealData['foods'] as $food) {
                if (!isset($food['name'])) continue;

                Diet::create([
                    'user_id' => $user->id,
                    'name' => $food['name'],
                    'calories' => $food['calories'] ?? 0,
                    'meal' => $mealData['meal'],
                    'diet_plan_id' => $plan->id
                ]);
            }
        }

        $meals = Diet::where('diet_plan_id', $plan->id)->get();

        $grouped = [];

        foreach ($meals as $meal) {
            $mealName = $meal->meal ?? 'Unknown';

            if (!isset($grouped[$mealName])) {
                $grouped[$mealName] = [
                    'foods' => [],
                    'total_calories' => 0
                ];
            }

            $grouped[$mealName]['foods'][] = [
                'name' => $meal->name,
                'calories' => $meal->calories
            ];

            $grouped[$mealName]['total_calories'] += $meal->calories;
        }

        return response()->json([
            'success' => true,
            'plan_id' => $plan->id,
            'diet' => $grouped
        ]);
    }

    public function generateDiet(Request $request)
    {
        $result = app(\App\Services\AIService::class)
            ->generateDiet(
                $request->goal,
                $request->weight,
                $request->meals
            );

        if ($result['success']) {
            AIDiet::create([
                'user_id' => $request->user()->id,
                'response' => json_encode($result['data'])
            ]);
        }

        return response()->json($result);
    }
}