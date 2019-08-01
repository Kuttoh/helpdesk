<?php

namespace App\Repositories;


use App\Ticket;
use App\TicketType;

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
        return $this->create($input);
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
}
