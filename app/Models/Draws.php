<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Draws extends Model
{
    use HasFactory;

    public function lottery()
    {
        return $this->belongsTo(Lottery::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
