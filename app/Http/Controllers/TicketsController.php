<?php

namespace App\Http\Controllers;

use App\Repositories\TicketRepository;
use App\TicketType;
use App\User;
use Illuminate\Http\Request;
use App\Ticket;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;

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
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        $types = TicketType::all();

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
        $users = User::all();

        $ticket = Ticket::findOrFail($id);

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
