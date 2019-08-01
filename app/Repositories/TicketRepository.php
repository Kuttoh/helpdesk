<?php

namespace App\Repositories;

use App\Ticket;

class TicketRepository
{
    public function orderedTickets()
    {
        return Ticket::latest()->get();
    }

    public function save($input)
    {
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
}
