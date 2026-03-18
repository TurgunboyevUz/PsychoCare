<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    protected $guarded = [];

    public function aliases()
    {
        return $this->hasMany(DrugName::class, 'drug_id', 'id');
    }

    public function relations()
    {
        return $this->hasMany(DrugRelation::class, 'primary_drug_id', 'id');
    }
}
