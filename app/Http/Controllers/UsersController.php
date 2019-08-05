<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth');

        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->role_id != 2){
            abort(401);
        }

        $allUsers = $this->userRepository->getAllUsers();

        return view('users.index', compact('allUsers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function edit(User $user)
    {
        if (auth()->user()->role_id != 2){
            abort(401);
        }

        return view('users.edit', compact('user'));
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
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        $this->userRepository->update($request->all(), $id);

        return redirect('/users');
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

    public function makeEngineer(Request $request, $userId)
    {
        if (auth()->user()->role_id != 2){
            abort(401);
        }

        $request = $request->all();

        $this->userRepository->postMakeEngineer($request, $userId);

        return redirect('/users');
    }
}
