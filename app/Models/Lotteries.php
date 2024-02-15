<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Draws;

class lotteries extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'ticket_price'];

    public function draws()
    {
        return $this->hasMany(Draws::class);
    }
}
