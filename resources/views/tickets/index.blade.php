@extends('layouts.app')

@section('content')

    <div class="container" style="margin-top: 10px">
        <div class="row justify-content-center">
            <h3>Tickets</h3>
            <table class="table table-responsive-md table-striped">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Type Name</th>
                    <th scope="col">Creator</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->type->name }}</td>
                        <td>{{ $ticket->creator->firstname }} {{ $ticket->creator->lastname }}</td>
                        <td>{{ $ticket->created_at }}</td>
                        <td>
                            <a href="{{$ticket->path()}}"><button type="submit" class="btn btn-outline-dark">View</button></a>
                            @if($ticket->ticket_status_id == 1)
                            <a href="{{$ticket->path()}}/edit"><button type="submit" class="btn btn-outline-info">Edit</button></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
