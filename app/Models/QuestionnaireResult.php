<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionnaireResult extends Model
{
    protected $guarded = [];

    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }
}
