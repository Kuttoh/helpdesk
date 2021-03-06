<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $table = 'replies';

    protected $guarded = ['id'];

    protected $with = ['owner'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ticket()
    {
        return $this->hasMany(Ticket::class);
    }
}
