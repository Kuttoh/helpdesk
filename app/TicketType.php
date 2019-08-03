<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    protected $fillable = ['name'];

    public function path()
    {
        return "/ticketTypes/{$this->id}";
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
