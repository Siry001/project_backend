<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkoutPlan;

class WorkoutPlanPolicy
{
    // 👇 مهم عشان index يشتغل
    public function viewAny(User $user): bool
    {
        return true;
    }

    // يشوف البلان
    public function view(User $user, WorkoutPlan $workoutPlan): bool
    {
        return $user->id === $workoutPlan->user_id;
    }
    // يعدل البلان
    public function update(User $user, WorkoutPlan $workoutPlan): bool
    {
        return $user->id === $workoutPlan->user_id;
    }

    // يمسح البلان
    public function delete(User $user, WorkoutPlan $workoutPlan): bool
    {
        return $user->id === $workoutPlan->user_id;
    }

    // ينشئ بلان جديد
    public function create(User $user): bool
    {
        return true;
    }
}