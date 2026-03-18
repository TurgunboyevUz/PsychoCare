<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    protected $guarded = [];

    public function questionnaire()
    {
        return $this->belongsTo(Question::class);
    }
}
