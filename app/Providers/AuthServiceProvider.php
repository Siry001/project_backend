<?php

namespace App\Providers;

use App\Models\WorkoutPlan;
use App\Policies\WorkoutPlanPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        WorkoutPlan::class => WorkoutPlanPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}