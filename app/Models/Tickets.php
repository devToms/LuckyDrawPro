<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    use HasFactory;

    public function draw()
    {
        return $this->belongsTo(Draw::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
