@extends('layouts.app')

@section('content')

    <div class="container" style="margin-top: 10px">
        <h3>Ticket Details</h3>
        <div class="row just">


            <div class="col-md-8">

                <div class="form-group">

                    <a href="{{ $ticket->path(). '/assign' }}" class="btn btn-outline-dark">Assign</a>
                    @if($ticket->assigned_to == null)
                    <a href="{{ $ticket->path(). '/take' }}" class="btn btn-outline-dark">Take-Up</a>
                    @endif
                    <a href="/tickets/{{ $ticket->id }}/edit" class="btn btn-outline-dark">Edit</a>
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

                @if(auth()->check())
                    <form method="POST" action="{{ $ticket->path(). '/replies' }}">
                        {{ csrf_field() }}
                        <div class="form-group">
{{--                            <input type="text" name="ticket_id" hidden value="{!! $ticket->id !!}" >--}}
                        <textarea name="body" id="body" rows="5" class="form-control"
                                  placeholder="Want to comment to this ticket?"></textarea>
                        </div>
                        <button type="submit" class="btn btn-outline- text-white" style="background-color: #9561e2">Comment</button>
                    </form>
                @else
                    <p class="text-center">Please <a href="{{ route('login') }}">Sign In</a> to comment on this ticket</p>
                @endif


            </div>

            <div class="col-md-4">
                <div class="card" style="margin-bottom:10px">
                    <div class="card-header bg-info text-white">Ticket Information</div>
                    <div class="card-body">
                        <p>Assigned to: {{ ($ticket->assignedTo)? $ticket->assignedTo->firstname .' '. $ticket->assignedTo->lastname : null}}</p>
                        <p>Ticket Status: {{ ($ticket->ticket_status_id)? $ticket->status->name : null}}</p>
                        <p>Created on: {{ $ticket->created_at }}</p>
                        <p>Created by: {{ $ticket->creator->firstname }} {{ $ticket->creator->lastname }} </p>
                        <p>No of
                            Comments: {{ $ticket->replies_count }} {{ str_plural('comment', $ticket->replies_count) }} </p>
                    </div>
                </div>
            </div>



        </div>
    </div>
@endsection
