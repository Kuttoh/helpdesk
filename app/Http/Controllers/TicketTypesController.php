<?php

namespace App\Http\Controllers;


use App\Repositories\TicketTypeRepository;
use App\Ticket;
use App\TicketType;
use Illuminate\Http\Request;

class TicketTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $ticketTypeRepository;

    public function __construct(TicketTypeRepository $ticketTypeRepository)
    {
        $this->middleware('auth');

        $this->ticketTypeRepository = $ticketTypeRepository;
    }

    public function index()
    {
        if (auth()->user()->role_id != 2) {
            return redirect('/tickets')->with('type', 'danger')->with('message', 'Access Denied!');
        }

        $ticketTypes = $this->ticketTypeRepository->getAllTicketTypes();

        return view('ticketTypes.index', compact('ticketTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ticketTypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:ticket_types,name',
        ]);

        $this->ticketTypeRepository->save($request->all());

        return redirect('/ticketTypes')->with('type', 'success')->with('message', 'Ticket Type Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function edit(TicketType $ticketType)
    {
        if (auth()->user()->role_id != 2) {
            return redirect('/tickets')->with('type', 'danger')->with('message', 'Access Denied!');
        }
        return view('ticketTypes.edit', compact('ticketType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:ticket_types,name',
        ]);

        $this->ticketTypeRepository->update($request->all(), $id);

        return redirect('ticketTypes')->with('type', 'success')->with('message', 'Ticket Type updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->user()->role_id != 2) {
            return redirect('/tickets')->with('type', 'danger')->with('message', 'Access Denied!');
        }

        $typeTypeInUse = Ticket::where('ticket_type_id', $id)->first();

        if ($typeTypeInUse) {
            return redirect('/ticketTypes')->with('type', 'warning')->with('message', 'Ticket Type in use!');
        }

        $this->ticketTypeRepository->delete($id);

        return redirect('ticketTypes')->with('type', 'success')->with('message', 'Ticket Type deleted!');
    }
}
