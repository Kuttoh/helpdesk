@extends('layouts.app')

@section('content')

    <div class="container" style="margin-top: 10px">
        <div class="row justify-content-center">
            <h3>Tickets</h3>
            <table class="table table-responsive-md table-striped">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Subject</th>
                    <th scope="col">Type</th>
                    <th scope="col">Creator</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->subject }}</td>
                        <td>{{ $ticket->type->name }}</td>
                        <td>{{ $ticket->creator->firstname }} {{ $ticket->creator->lastname }}</td>
                        <td>{{ $ticket->created_at }}</td>
                        <td>
                            <a href="{{$ticket->path()}}">
                                <button type="submit" class="btn btn-outline-dark"><i class="fa fa-eye"></i> </button>
                            </a>
                            @if($ticket->ticket_status_id != 2 and $ticket->creator->id == auth()->id())
                                <a href="{{$ticket->path()}}/edit">
                                    <button type="submit" class="btn btn-outline-info"><i class="fa fa-edit"></i> </button>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $tickets->links() }}
        </div>
    </div>

@endsection
