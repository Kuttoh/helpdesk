<?php

namespace App\Repositories;


use App\Ticket;
use App\TicketType;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TicketRepository
{
    public function orderedTickets()
    {
        return Ticket::latest()
            ->with(['replies', 'creator'])
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

        if($ticket['user_id'] == $userId){
            abort(403, 'This user cannot be assigned the ticket');
        }

        $ticket->update(['assigned_to' => $userId]);

        return redirect($ticket->path());
    }

    public function postTake($input, $id)
    {
        $ticket = $this->getTicketById($id);

        if ($ticket['user_id'] == auth()->id()){
            abort(403, 'Why would you want to take-up a ticket you created?');
        }

        $ticket->update(['assigned_to' => auth()->id()]);

        return redirect($ticket->path());
    }


    public function closeTicket($input, $id)
    {
        $ticket = $this->getTicketById($id);

        if (auth()->user()->role_id == 2 or $ticket['assigned_to'] == auth()->id()) {
            $ticket->update([
                'ticket_status_id' => 2,
                'closed_at' => Carbon::now()
            ]);
        } else {
            abort(403, 'You have no permission to close this ticket');

        }

        $ticket->update([
            'ticket_status_id' => 2,
            'closed_at' => Carbon::now()
            ]);

        return redirect($ticket->path());
    }

    public function openTicket($input, $id)
    {
        $ticket = $this->getTicketById($id);

        $ticket->update([
            'ticket_status_id' => 1,
            'updated_at' => Carbon::now(),
            'closed_at' => null,
        ]);

        return redirect($ticket->path());
    }
}
