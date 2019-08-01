<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function path()
    {
        return "/tickets/{$this->type->slug}/{$this->id}";
    }

    public function type()
    {
        return $this->belongsTo(TicketType::class, 'ticket_type_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
