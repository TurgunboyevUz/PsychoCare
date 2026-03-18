<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrugName extends Model
{
    protected $guarded = [];

    public function primary()
    {
        return $this->belongsTo(Drug::class, 'drug_id', 'id');
    }
}
