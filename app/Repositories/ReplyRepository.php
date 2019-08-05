<?php

namespace App\Repositories;


use App\Reply;

class ReplyRepository
{

    public function save($input)
    {
        $input['user_id'] = auth()->id();

        return Reply::create($input);
    }
}
