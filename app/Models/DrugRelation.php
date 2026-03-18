<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrugRelation extends Model
{
    protected $guarded = [];
    protected $casts   = ['metadata' => 'array'];

    public function primaryDrug()
    {
        return $this->belongsTo(Drug::class, 'primary_drug_id');
    }

    public function secondaryDrug()
    {
        return $this->belongsTo(Drug::class, 'secondary_drug_id');
    }
}
