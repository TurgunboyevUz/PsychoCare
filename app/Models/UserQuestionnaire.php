<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class UserQuestionnaire extends Model
{
    protected $guarded = [];

    protected $casts = [
        'answers' => 'array',
    ];

    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class, 'questionnaire_id', 'id');
    }

    public function result()
    {
        return $this->belongsTo(QuestionnaireResult::class, 'questionnaire_result_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(TeleUser::class, 'tele_user_id', 'id');
    }

    public function time(): Attribute
    {
        return Attribute::make(
            fn () => gmdate('H:i:s', $this->session_interval)
        );
    }
}
