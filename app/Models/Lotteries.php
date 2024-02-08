<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lotteries extends Model
{
    use HasFactory;

    public function draws()
    {
        return $this->hasMany(Draw::class);
    }
}
