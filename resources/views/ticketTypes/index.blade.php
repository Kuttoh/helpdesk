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
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ticketTypes as $ticketType)
                    <tr>
                        <td>{{ $ticketType->name }}</td>
                        <td>{{ $ticketType->created_at }}</td>
                        <td>
                            <a href="ticketType/edit"><button type="submit" class="btn btn-outline-info">Edit</button></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
