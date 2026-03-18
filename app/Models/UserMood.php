<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMood extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(TeleUser::class, 'tele_user_id', 'id');
    }

    public function mood()
    {
        return $this->belongsTo(Mood::class, 'mood_id', 'id');
    }

    public static function lastMood($user_id)
    {
        $mood = self::where('tele_user_id', $user_id)->latest()->first();

        if (! $mood || $mood?->created_at->addHour()->lt(now())) {
            return;
        }

        return $mood;
    }
}
