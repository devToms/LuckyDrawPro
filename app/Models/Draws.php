<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lotteries;
use App\Models\Tickets;

class Draws extends Model
{
    use HasFactory;

    protected $fillable = ['draw_date', 'won_number'];

    public function lotteries()
    {
        return $this->belongsTo(Lotteries::class);
    }

    public function tickets()
    {
        return $this->hasMany(Tickets::class);
    }
}
