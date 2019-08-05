@extends('layouts.app')

@section('content')

    <div class="container" style="margin-top: 10px">
        <h3>Ticket Details</h3>
        <div class="row just">
            <div class="col-md-8">
                <div class="form-group">
                    @if($ticket->ticket_status_id != 2)
                        @if($user->role_id == 2)
                            <a href="{{ $ticket->path(). '/assign' }}" class="btn btn-outline-dark">Assign</a>
                        @endif
                        @if($ticket->creator->id == $user->id)
                            <a href="/tickets/{{ $ticket->id }}/edit" class="btn btn-outline-dark">Edit</a>
                        @endif
                    @endif
                    @if($ticket->assigned_to == null and $ticket->creator->id != $user->id and $ticket->ticket_status_id != 2)
                        <a href="{{ $ticket->path(). '/take' }}" class="btn btn-outline-dark">Take-Up</a>
                    @endif
                    @if($ticket->ticket_status_id != 2)
                        @if($ticket->assigned_to == $user->id or $ticket->creator->id == $user->id or $user->role_id == 2)
                            <a href="/tickets/{{ $ticket->id }}/closeStatus" class="btn btn-outline-dark">Close
                                Ticket</a>
                        @endif
                    @endif
                    @if($ticket->ticket_status_id == 2)
                        <a href="/tickets/{{ $ticket->id }}/openStatus" class="btn btn-outline-dark">Re-Open
                            Ticket</a>
                    @endif
                </div>

                <div class="card" style="margin-bottom:10px">
                    <div class="card-header text-white" style="background-color: #9561e2">
                        <h5>Subject: {{ $ticket->subject }}</h5>
                    </div>
                    <div class="card-body">
                        {{$ticket->body}}
                    </div>
                </div>

                @foreach($ticket->replies as $reply)
                    <div class="card" style="margin-bottom:10px">
                        <div class="card-body">
                            {{$reply->body }}
                            <footer class="blockquote-footer">Replied
                                by {{ $reply->owner->lastname }} {{$reply->created_at->diffForHumans()}}
                            </footer>
                        </div>
                    </div>
                @endforeach

                @if(empty($ticket->assignedTo))
                    <p>Ticket has not yet been assigned</p>
                @else
                    @if($ticket->ticket_status_id != 2)
                        <form method="POST" action="{{ $ticket->path(). '/replies' }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                    <textarea name="body" id="body" rows="5" class="form-control"
                                              placeholder="Want to comment to this ticket?"></textarea>
                            </div>
                            <button type="submit" class="btn btn-outline- text-white"
                                    style="background-color: #9561e2">Comment
                            </button>
                        </form>
                    @endif
                @endif
            </div>

            <div class="col-md-4">
                <div class="card" style="margin-bottom:10px">
                    <div class="card-header bg-info text-white">Ticket Information</div>
                    <div class="card-body">
                        <p>Assigned
                            to: {{ ($ticket->assignedTo)? $ticket->assignedTo->firstname .' '. $ticket->assignedTo->lastname : null}}</p>
                        <p>Ticket Status: {{ ($ticket->ticket_status_id)? $ticket->status->name : null}}</p>
                        @if($ticket->ticket_status_id == 2)
                            <p>Closed on: {{ $ticket->updated_at}}</p>
                        @endif
                        <p>Created on: {{ $ticket->created_at }}</p>
                        <p>No of
                            Comments: {{ $ticket->replies_count }} {{ str_plural('comment', $ticket->replies_count) }} </p>
                    </div>
                </div>

                @if(auth()->check())
                    <div class="card" style="margin-bottom:10px">
                        <div class="card-header bg-info text-white">Creator Information</div>
                        <div class="card-body">
                            <p>Name: {{ $ticket->creator->firstname }} {{ $ticket->creator->lastname }} </p>
                            <p>Email: {{ $ticket->creator->email }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
