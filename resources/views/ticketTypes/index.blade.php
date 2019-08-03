@extends('layouts.app')

@section('content')

    <div class="container" style="margin-top: 10px">
        <div class="row justify-content-center">
            <h3>Ticket Types</h3>
                <table class="table table-responsive-md table-striped">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Type</th>
                    <th scope="col">Date Created</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ticketTypes as $ticketType)
                    <tr>
                        <td>{{ $ticketType->name }}</td>
                        <td>{{ $ticketType->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
        <a href="/ticketTypes/create" class="btn btn-outline-dark">Create New</a>
    </div>

@endsection
