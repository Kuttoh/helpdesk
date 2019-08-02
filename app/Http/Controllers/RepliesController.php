<?php

namespace App\Http\Controllers;

use App\Repositories\ReplyRepository;
use App\Ticket;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    protected $replyRepository;

    public function __construct(ReplyRepository $replyRepository)
    {
        $this->replyRepository = $replyRepository;
    }

    public function store(Request $request, $ticketId)
    {
        $request = $request->all();

        $request['ticket_id'] = $ticketId;

        $this->replyRepository->save($request);

        return redirect('tickets/'. $ticketId);
    }
}
