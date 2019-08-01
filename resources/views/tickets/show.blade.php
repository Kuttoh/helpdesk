@extends('layouts.app')

@section('content')

    <div class="container" style="margin-top: 10px">
        <div class="row just">

            <div class="col-md-8">
                <div class="card" style="margin-bottom:10px">
                    <div class="card-header bg-dark text-white">
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
                                by {{ $reply->owner->lastname }} {{$reply->created_at->diffForHumans()}}</footer>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-4">
                <div class="card" style="margin-bottom:10px">
                    <div class="card-header bg-dark text-white">Ticket Information</div>
                    <div class="card-body">
                        <p>This ticket was created {{ $ticket->created_at->diffForHumans() }} by
                            {{ $ticket->creator->lastname }}, and
                            has {{ $ticket->replies_count }} {{ str_plural('comment', $ticket->replies_count) }}.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
