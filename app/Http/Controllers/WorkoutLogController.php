<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkoutLog;

class WorkoutLogController extends Controller
{
    public function index()
    {
        return WorkoutLog::with('workout')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'workout_id' => 'required|integer',
            'weight' => 'required|integer',
            'reps' => 'required|integer',
            'sets' => 'required|integer',
            'performed_at' => 'required|date'
        ]);

        $log = WorkoutLog::create($data);

        return response()->json($log, 201);
    }

    public function show(WorkoutLog $workoutLog)
    {
        return $workoutLog->load('workout');
    }

    public function destroy(WorkoutLog $workoutLog)
    {
        $workoutLog->delete();

        return response()->json([
            'message' => 'Log deleted'
        ]);
    }
}