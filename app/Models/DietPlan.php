<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class DietPlan extends Model
{
    protected $fillable = [
        'title',
        'description',
        'user_id'
    ];

    // خطة الدايت تتبع مستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}