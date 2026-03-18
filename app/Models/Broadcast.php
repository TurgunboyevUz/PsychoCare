<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    protected $guarded = [];

    protected $casts = [
        'in_top' => 'boolean',
        'buttons'      => 'array',
        'scheduled_at' => 'datetime',
    ];

    public function logs()
    {
        return $this->hasMany(BroadcastLog::class, 'broadcast_id', 'id');
    }

    public function image_url()
    {
        if (! $this->image) {return;}

        if (str_starts_with($this->image, 'http')) {return $this->image;}

        return asset('storage/' . $this->image);
    }
}
