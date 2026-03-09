<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutPlan extends Model
{
    protected $fillable = [
        'plan_text',
        'user_id'
    ];

    public function workouts()
    {
        return $this->hasMany(Workout::class);
    }
}