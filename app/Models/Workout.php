<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $fillable = [
        'name',
        'description',
        'duration',
        'user_id',
        'workout_plan_id'
    ];

    public function plan()
    {
        return $this->belongsTo(WorkoutPlan::class,'workout_plan_id');
    }
}