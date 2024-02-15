<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Draws;
use App\Models\User;

class Tickets extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'draw_id', 'number', 'bought_date'];

    public function draws()
    {
        return $this->belongsTo(Draws::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
