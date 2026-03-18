<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeleUser extends Model
{
    protected $guarded = [];

    protected $casts = [
        'timezone' => 'integer',
    ];

    public function mood_types()
    {
        return $this->hasMany(UserMoodType::class, 'tele_user_id', 'id');
    }

    public function moods()
    {
        return $this->hasMany(UserMood::class, 'tele_user_id', 'id');
    }

    public function questionnaires()
    {
        return $this->hasMany(UserQuestionnaire::class, 'tele_user_id', 'id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'tele_user_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany(BroadcastLog::class, 'broadcast_id', 'id');
    }
}
