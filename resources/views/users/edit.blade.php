@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 10px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">Edit Ticket Type</div>

                    @if ($errors->any())
                        <div class="notification is-danger text-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card-body">

                        <form method="post" action="{{$user->path()}}/update">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="firstname">First Name:</label>
                                <input name="firstname" type="text" class="form-control" id="firstname" required value="{{ $user->firstname }}">
                            </div>

                            <div class="form-group">
                                <label for="lastname">Last Name:</label>
                                <input name="lastname" type="text" class="form-control" id="lastname" required value="{{ $user->lastname }}">
                            </div>

                            <div class="form-group">
                                <label for="email">E-mail:</label>
                                <input name="email" type="text" class="form-control" id="email" required value="{{ $user->email }}">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-dark">Edit</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
