<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutLog extends Model
{
    protected $fillable = [
        'workout_id',
        'weight',
        'reps',
        'sets',
        'performed_at'
    ];

    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }
}