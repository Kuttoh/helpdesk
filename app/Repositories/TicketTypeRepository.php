<?php

namespace App\Repositories;

use App\TicketType;

class TicketTypeRepository
{

    public function getAllTicketTypes()
    {
        return TicketType::Paginate(9);
    }

    public function save($input)
    {
        return TicketType::create($input);
    }

    public function getTicketTypeById($id)
    {
        return TicketType::findOrFail($id);
    }

    public function update($input, $id)
    {
        $ticketType = $this->getTicketTypeById($id);

        $ticketType->update($input);
    }

    public function delete($id)
    {
        $ticket = $this->getTicketTypeById($id);

        $ticket->delete();
    }
}
