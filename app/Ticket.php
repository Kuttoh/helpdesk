<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table ='tickets';

    protected $guarded =['id'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });
    }

    public function path()
    {
        return "/tickets/{$this->id}";
    }

    public function type()
    {
        return $this->belongsTo(TicketType::class, 'ticket_type_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function replies()
    {
        return $this->hasMany(Reply::class);
    }


    public function assignedTo()
    {
       return $this->belongsTo(User::class,'assigned_to');
    }

    public function status()
    {
        return $this->belongsTo(TicketStatus::class, 'ticket_status_id' );
    }
}
