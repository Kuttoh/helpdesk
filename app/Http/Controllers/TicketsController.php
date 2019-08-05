<?php

namespace App\Http\Controllers;

use App\Mail\TicketCreated;
use App\Repositories\TicketRepository;
use App\Repositories\TicketTypeRepository;
use App\TicketType;
use App\User;
use Illuminate\Http\Request;
use App\Ticket;
use Illuminate\Support\Facades\Mail;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $ticketRepository, $ticketTypeRepository;

    public function __construct(TicketRepository $ticketRepository, TicketTypeRepository $ticketTypeRepository)
    {
        $this->ticketRepository = $ticketRepository;

        $this->ticketTypeRepository = $ticketTypeRepository;

        $this->middleware('auth')->except('index', 'show');
    }

    public function index()
    {
        $tickets = $this->ticketRepository->orderedTickets();

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = TicketType::all();

        return view('tickets.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ticket = $this->ticketRepository->save($request->all());

        Mail::to('ithelpdesk@cytonn.com')->queue(
            new TicketCreated($ticket)
        );

        return redirect($ticket->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        if (auth()->check() == true) {

            $user = User::findOrFail(auth()->id());

            return view('tickets.show', compact(['ticket', 'user']));

        } else {

            return view('tickets.show', compact('ticket'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        if (auth()->user()->id != $ticket->user_id){
            abort(403, 'You are not allowed to edit this ticket');
        }

        $types = $this->ticketTypeRepository->orderedTicketTypes();

        return view('tickets.edit', compact(['ticket', 'types']));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->ticketRepository->update($request->all(), $id);

        return redirect('tickets');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function assign($id)
    {
        if (auth()->user()->role_id != 2){
            abort(401);
        }

        $users = User::all();

        $ticket = $this->ticketRepository->getTicketById($id);

        if($ticket['ticket_status_id'] == 2){
            abort(403, 'Ticket is already closed' );
        }
        return view('tickets.assign', compact(['users', 'ticket']));
    }

    /**
     * @param Request $request
     * @param $ticketId
     */
    public function storeAssign(Request $request, $ticketId)
    {
        $request = $request->all();

        $this->ticketRepository->postAssign($request, $ticketId);

        return redirect('tickets/'. $ticketId);
    }

    public function storeTake(Request $request, $ticketId)
    {
        $request = $request->all();

        $this->ticketRepository->postTake($request, $ticketId);

        return redirect('tickets/'. $ticketId);
    }

    public function closeStatus(Request $request, $ticketId)
    {
        $request = $request->all();

        $this->ticketRepository->closeTicket($request, $ticketId);

        return redirect('tickets/'. $ticketId);
    }

    public function openStatus(Request $request, $ticketId)
    {
        $request = $request->all();

        $this->ticketRepository->openTicket($request, $ticketId);

        return redirect('tickets/'. $ticketId);
    }
}
