<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Models\Workout;
use App\Models\WorkoutPlan;
use App\Models\WorkoutLog;
use App\Models\DietPlan;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // علاقة المستخدم بالتمارين
    public function workouts()
    {
        return $this->hasMany(Workout::class);
    }

    // علاقة المستخدم بخطط التمرين
    public function workoutPlans()
    {
        return $this->hasMany(WorkoutPlan::class);
    }

    // علاقة المستخدم بسجلات التمرين
    public function workoutLogs()
    {
        return $this->hasMany(WorkoutLog::class);
    }

    // علاقة المستخدم بخطط الدايت
    public function dietPlans()
    {
        return $this->hasMany(DietPlan::class);
    }
}