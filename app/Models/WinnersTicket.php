<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinnersTicket extends Model
{
    use HasFactory;

    protected $table = 'winners_ticket';

    protected $fillable = ['draw_id', 'user_id', 'ticket_id'];

    public function draws()
    {
        return $this->belongsTo(Draws::class, 'draw_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tickets()
    {
        return $this->belongsTo(Tickets::class, 'ticket_id');
    }
}
