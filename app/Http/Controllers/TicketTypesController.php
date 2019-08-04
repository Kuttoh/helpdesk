<?php

namespace App\Http\Controllers;


use App\Repositories\TicketTypeRepository;
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
        if ( auth()->user()->role_id != 2){
            abort(401);
        }

       $ticketTypes = $this->ticketTypeRepository->orderedTicketTypes();

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:ticket_types,name',
        ]);

        $this->ticketTypeRepository->save($request->all());

        return redirect('/ticketTypes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TicketType $ticketType)
    {
        //
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
}
