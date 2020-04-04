<?php

namespace App\Repositories;

use App\Mail\TicketAssigned;
use App\Mail\TicketClosed;
use App\Mail\TicketEdited;
use App\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class TicketRepository
{
    public function orderedTickets()
    {
        if (auth()->user()->role_id != 2) {
            return Ticket::with('type', 'creator', 'status', 'replies', 'assignedTo')
                ->where('user_id', auth()->id())->latest()->paginate(9);

        } else {
            return Ticket::with('type', 'creator', 'status', 'replies', 'assignedTo')
                ->latest()->paginate(9);
        }
    }

    public function myAssignedTickets()
    {
        return Ticket::with('type', 'creator')
            ->where('assigned_to', auth()->id())->latest()->paginate(9);
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
            return redirect($ticket->path())
                ->with('message', 'This user cannot be assigned the ticket')
                ->with('type', 'warning');
        }

        if ($ticket['ticket_status_id'] == 2) {
            return redirect( $ticket->path())
                ->with('message', 'Ticket is already closed')
                ->with('type', 'danger');
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

        return redirect($ticket->path())->with('type', 'success')->with('message', 'Assigned Successfully!');
    }

    public function postTake($id)
    {
        $ticket = $this->getTicketById($id);

        if($ticket['ticket_status_id'] == 2){
            return redirect( $ticket->path())
                ->with('message', 'Ticket is already closed')
                ->with('type', 'danger');
        }

        if ($ticket['user_id'] == auth()->id()){
            return redirect( $ticket->path())
                ->with('message', 'Why would you want to take-up a ticket you created?')
                ->with('type', 'warning');
        }

        if (auth()->user()->role_id != 2){
            return redirect( $ticket->path())
                ->with('message', 'Access Denied')
                ->with('type', 'danger');
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

        return redirect($ticket->path())->with('type', 'success')->with('message', 'Successfully assigned to you!');
    }


    public function closeTicket($id)
    {
        $ticket = $this->getTicketById($id);

        if (auth()->user()->role_id == 2 or $ticket['assigned_to'] == auth()->id()) {
            $ticket->update([
                'ticket_status_id' => 2, //Closed Ticket
                'closed_at' => Carbon::now()
            ]);
        } else {
            return redirect( $ticket->path())->with('message', 'Access Denied')->with('type', 'danger');
        }

        $ticket->update([
            'ticket_status_id' => 2,
            'closed_at' => Carbon::now()
            ]);

        Mail::to($ticket->creator->email)
            ->cc('ithelpdesk@cytonn.com')
            ->queue(
                new TicketClosed($ticket)
            );

        return redirect($ticket->path())->with('type', 'success')->with('message', 'Closed Successfully!');
    }

    public function openTicket($id)
    {
        $ticket = $this->getTicketById($id);

        $ticket->update([
            'ticket_status_id' => 1,
//            'assigned_to' => null,
            'updated_at' => Carbon::now(),
            'closed_at' => null,
        ]);

        return redirect($ticket->path())->with('type', 'success')->with('message', 'Re-Opened Successfully!');
    }
}
