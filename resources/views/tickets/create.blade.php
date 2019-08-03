@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 10px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">Create A New Ticket</div>

                    @if ($errors->any())
                        <div class="notification is-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card-body">

                        <form method="post" action="/tickets">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="ticket_type_id">Select Ticket Type:</label>
                                <select name="ticket_type_id" id="ticket_type_id" class="form-control" required>
                                    <option value="">Choose One...</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id}}" {{ old('ticket_type_id') == $type->id ? 'selected': '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="subject">Subject:</label>
                                <input name="subject" type="text" class="form-control" id="subject"
                                       value="{{ old('subject') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="body">Body:</label>
                                <textarea class="form-control" id="body" name="body"
                                          rows="8" required>{{ old('body') }}</textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-dark">Create</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


