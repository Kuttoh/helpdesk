@extends('layouts.app')

@section('content')

    <div class="container" style="margin-top: 10px">
        <div class="row">

        </div>
        <div class="row justify-content-center">
            <h4>Ticket Types</h4>
            <a href="/ticketTypes/create" class="btn btn-outline-success float-right ml-auto mb-1">Create New</a>
            <table class="table table-responsive-md table-striped">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Type</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ticketTypes as $ticketType)
                    <tr>
                        <td>{{ $ticketType->name }}</td>
                        <td>{{ $ticketType->created_at }}</td>
                        <td>
                            <a class="btn btn-outline-info" href="{{ $ticketType->path() }}/edit"><i class="fa fa-edit"></i> </a>
                            <a class="btn btn-outline-danger" href="{{ $ticketType->path() }}/delete"><i class="fa fa-trash"></i> </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $ticketTypes->links() }}
        </div>
    </div>

@endsection
