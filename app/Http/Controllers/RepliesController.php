<?php

namespace App\Http\Controllers;

use App\Mail\TicketRepliedTo;
use App\Repositories\ReplyRepository;
use App\Repositories\TicketRepository;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RepliesController extends Controller
{
    protected $replyRepository;

    protected $ticketRepository;

    public function __construct(ReplyRepository $replyRepository, TicketRepository $ticketRepository)
    {
        $this->replyRepository = $replyRepository;

        $this->ticketRepository = $ticketRepository;
    }

    public function store(Request $request, $ticketId)
    {
        $request = $request->all();

        $request['ticket_id'] = $ticketId;

        $reply = $this->replyRepository->save($request);

        $ticket = $this->ticketRepository->getTicketById($ticketId);

        if ($ticket->creator->id == $reply['user_id']) {
            Mail::to($ticket->assignedTo->email)
                ->cc($ticket->creator->email)
                ->queue(
                    new TicketRepliedTo($ticket, $reply)
                );
        } else {
            Mail::to($ticket->creator->email)
                ->cc($ticket->assignedTo->email)
                ->queue(
                    new TicketRepliedTo($ticket, $reply)
                );
        }

        return redirect('tickets/'. $ticketId);
    }
}
