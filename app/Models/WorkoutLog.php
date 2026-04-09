<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Workout;

class WorkoutLog extends Model
{
    protected $fillable = [
        'user_id',
        'workout_id',
        'weight',
        'reps',
        'sets',
        'performed_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }
}