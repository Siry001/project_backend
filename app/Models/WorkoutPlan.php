<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Workout;

class WorkoutPlan extends Model
{
    protected $fillable = [
        'plan_text',
        'user_id'
    ];

    // الخطة تتبع مستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // الخطة تحتوي تمارين
    public function workouts()
    {
        return $this->hasMany(Workout::class);
    }
}