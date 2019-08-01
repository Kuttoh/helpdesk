@extends('layouts.app')

@section('title', 'Tickets')

@section('content')

    <div class="container" style="margin-top: 10px">
        <div class="row justify-content-center">
            <h3>Tickets</h3>
            <table class="table table-responsive-md">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Type</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->type->name }}</td>
                        <td>{{ $ticket->creator->firstname }}</td>
                        <td>{{ $ticket->creator->lastname }}</td>
                        <td>{{ $ticket->created_at }}</td>
                        <td><a href="/tickets/". {{$ticket->path()}}><button type="submit" class="btn btn-outline-dark">View</button></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

{{--    <a href="/projects/create"><button type="submit" class="button is-link">Create New</button></a>--}}

@endsection
