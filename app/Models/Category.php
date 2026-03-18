<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function questionnaires()
    {
        return $this->hasMany(Questionnaire::class, 'category_id', 'id');
    }
}
