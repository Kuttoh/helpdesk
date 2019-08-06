<?php

namespace App\Repositories;

use App\Mail\TicketAssigned;
use App\Mail\TicketEdited;
use App\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class TicketRepository
{
    public function orderedTickets()
    {
        if (auth()->user()->role_id != 2) {
            return Ticket::where('user_id', auth()->id())->latest()->get();

        } else {
            return Ticket::latest()->get();
        }
    }

    public function myAssignedTickets()
    {
        return Ticket::where('assigned_to', auth()->id())->latest()->get();
    }

    public function save($input)
    {
        $input['user_id'] = auth()->id();
        $input['ticket_status_id'] = 1; //Open Ticket (Default Status)

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

        Mail::to('ithelpdesk@cytonn.com')->queue(
            new TicketEdited($ticket)
        );
    }

    public function delete($id)
    {
        $ticket = $this->getTicketById($id);

        $ticket->delete();
    }

    public function postAssign($input, $id)
    {
        $ticket = $this->getTicketById($id);

        $userId = $input['user_id'];

        if ($ticket['user_id'] == $userId) {
            abort(403, 'This user cannot be assigned the ticket');
        }

        if ($ticket['ticket_status_id'] == 2) {
            abort(403, 'Ticket is already closed');
        }

        $ticket->update([
            'assigned_to' => $userId,
            'ticket_status_id' => 3, // In Progress Ticket
        ]);

        Mail::to($ticket->assignedTo->email)
            ->cc([$ticket->creator->email, 'ithelpdesk@cytonn.com'])
            ->queue(
                new TicketAssigned($ticket)
            );

        return redirect($ticket->path());
    }

    public function postTake($input, $id)
    {
        $ticket = $this->getTicketById($id);

        if($ticket['ticket_status_id'] == 2){
            abort(403, 'Ticket is already closed' );
        }

        if ($ticket['user_id'] == auth()->id()){
            abort(403, 'Why would you want to take-up a ticket you created?');
        }

        if (auth()->user()->role_id != 2){
            abort(403, 'You cannot take-up a ticket');
        }

        $ticket->update([
            'assigned_to' => auth()->id(),
            'ticket_status_id' => 3
            ]);

        Mail::to($ticket->assignedTo->email)
            ->cc($ticket->creator->email)
            ->queue(
                new TicketAssigned($ticket)
            );

        return redirect($ticket->path());
    }


    public function closeTicket($input, $id)
    {
        $ticket = $this->getTicketById($id);

        if (auth()->user()->role_id == 2 or $ticket['assigned_to'] == auth()->id()) {
            $ticket->update([
                'ticket_status_id' => 2, //Closed Ticket
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
            'assigned_to' => null,
            'updated_at' => Carbon::now(),
            'closed_at' => null,
        ]);

        return redirect($ticket->path());
    }
}
