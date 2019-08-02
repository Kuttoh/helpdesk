<?php

namespace App\Repositories;


use App\Ticket;
use App\TicketType;
use Illuminate\Http\Request;

class TicketRepository
{
    public function orderedTickets()
    {
        return Ticket::latest()
            ->with('replies')
            ->get();
    }

    public function save($input)
    {
        $input['user_id'] = auth()->id();
        $input['ticket_status_id'] = 1;

        return Ticket::create($input);
    }

    public function getTicketById($id)
    {
        return Ticket::findOrFail($id);
    }

    public function update($input, $id)
    {
        $ticket = $this->getTicketById($id);

        $ticket->update($input);
    }

    public function delete($id)
    {
        $ticket = $this->getTicketById($id);

        $ticket->delete();
    }

//    public function getTickets(TicketType $type)
//    {
//        $tickets = Ticket::latest();
//
//        if ($type->exists) {
//            $tickets->where('ticket_type_id', $type->id);
//        }
//
//        $tickets = $tickets->get();
//
//        return $tickets;
//    }

    public function postAssign($input, $id)
    {
        $ticket = $this->getTicketById($id);

        $userId = $input['user_id'];

        $ticket->update(['assigned_to' => $userId]);

        return redirect($ticket->path());
    }

    public function postTake($input, $id)
    {
        $ticket = $this->getTicketById($id);

        $ticket->update(['assigned_to' => auth()->id()]);

        return redirect($ticket->path());
    }
}
