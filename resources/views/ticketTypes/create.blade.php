@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 10px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">Create A New Ticket Type</div>

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

                        <form method="post" action="/ticketTypes/store">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="subject">Type Name:</label>
                                <input name="name" type="text" class="form-control" id="name"
                                       value="{{ old('name') }}" required>
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


