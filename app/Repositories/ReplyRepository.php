<?php

namespace App\Repositories;


use App\Reply;
use App\Ticket;

class ReplyRepository
{

    public function save($input)
    {
        $input['user_id'] = auth()->id();

        return Reply::create($input);
    }
}
