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
                                    <option value="">Choose One...</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id}}" {{ old('ticket_type_id') == $type->id ? 'selected': '' }}>
                                            {{ $type->slug }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


