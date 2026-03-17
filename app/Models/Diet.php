<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diet extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'calories',
        'meal',
        'diet_plan_id'
    ];
}