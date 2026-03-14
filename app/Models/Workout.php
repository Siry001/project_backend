<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\WorkoutPlan;
use App\Models\WorkoutLog;

class Workout extends Model
{
    protected $fillable = [
        'name',
        'description',
        'duration',
        'user_id',
        'workout_plan_id'
    ];

    // التمرين يتبع مستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // التمرين يتبع خطة
    public function plan()
    {
        return $this->belongsTo(WorkoutPlan::class,'workout_plan_id');
    }

    // التمرين له logs
    public function logs()
    {
        return $this->hasMany(WorkoutLog::class);
    }
}