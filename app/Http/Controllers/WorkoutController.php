<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workout;
use App\Models\WorkoutLog;

class WorkoutController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->workouts;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'duration' => 'required|integer',
            'workout_plan_id' => 'nullable|integer'
        ]);

        $data['user_id'] = $request->user()->id;

        $workout = Workout::create($data);

        return response()->json($workout, 201);
    }

    public function show(Request $request, Workout $workout)
    {
        if ($workout->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $workout;
    }

    public function update(Request $request, Workout $workout)
    {
        if ($workout->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'name' => 'string',
            'description' => 'nullable|string',
            'duration' => 'integer'
        ]);

        $workout->update($data);

        return $workout;
    }

    public function destroy(Request $request, Workout $workout)
    {
        if ($workout->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $workout->delete();

        return response()->json([
            'message' => 'Workout deleted successfully'
        ]);
    }

    public function progress(Request $request, $id)
    {
    $workout = Workout::where('id', $id)
        ->where('user_id', $request->user()->id)
        ->first();

    if (!$workout) {
        return response()->json(['message' => 'Workout not found'], 404);
    }

    $logs = $workout->logs;

    return response()->json([
        'workout_id' => $id,
        'total_sessions' => $logs->count(),
        'best_weight' => $logs->max('weight'),
        'last_session' => $logs->sortByDesc('performed_at')->first()
    ]);
    }
}