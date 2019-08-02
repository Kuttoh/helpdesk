@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 10px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Assign Ticket</div>

                    <div class="card-body">

                        <form method="post" action="{{ $ticket->path() }}/assign">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="user_id">Select User:</label>
                                <select name="user_id" id="user_id" class="form-control" required>
                                    <option value="">Choose user...</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id}}">
                                            {{ $user->firstname }} {{ $user->lastname }}({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-outline-dark">Assign</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


