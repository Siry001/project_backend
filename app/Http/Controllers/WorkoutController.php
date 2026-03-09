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

    public function show(Workout $workout)
    {
        return $workout;
    }

    public function update(Request $request, Workout $workout)
    {
        $workout->update($request->all());
        return $workout;
    }

    public function destroy(Workout $workout)
    {
        $workout->delete();

        return response()->json([
            'message' => 'Deleted'
        ]);
    }

    public function progress($id)
    {
        $logs = WorkoutLog::where('workout_id', $id)->get();

        return response()->json([
            'workout_id' => $id,
            'total_sessions' => $logs->count(),
            'best_weight' => $logs->max('weight'),
            'last_session' => $logs->sortByDesc('performed_at')->first()
        ]);
    }
}