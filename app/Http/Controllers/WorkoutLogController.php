<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkoutLog;

class WorkoutLogController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->workoutLogs()->with('workout')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'workout_id'   => 'required|integer',
            'weight'       => 'required|integer',
            'reps'         => 'required|integer',
            'sets'         => 'required|integer',
            'performed_at' => 'required|date'
        ]);

        $data['user_id'] = $request->user()->id;

        $log = WorkoutLog::create($data);

        return response()->json($log, 201);
    }

    public function show(Request $request, WorkoutLog $log)
    {
        if ($log->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $log->load('workout');
    }

    public function destroy(Request $request, WorkoutLog $log)
    {
        if ($log->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $log->delete();

        return response()->json([
            'message' => 'Log deleted'
        ]);
    }
}