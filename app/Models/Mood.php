<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mood extends Model
{
    protected $guarded = [];

    public function user_moods()
    {
        return $this->hasMany(UserMood::class, 'tele_user_id', 'id');
    }

    public function user_mood_types()
    {
        return $this->hasMany(UserMoodType::class, 'mood_id', 'id');
    }
}
