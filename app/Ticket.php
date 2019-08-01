<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

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

    public function assignee()
    {
        $this->belongsTo(TicketAssignee::class);
    }
}
