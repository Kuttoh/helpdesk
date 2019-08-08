@extends('layouts.app')

@section('content')

    <div class="container" style="margin-top: 10px">
        <div class="row justify-content-center">
            <h3>Users</h3>
            <table class="table table-responsive-md table-striped">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Role</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($allUsers as $user)
                    <tr>
                        <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->name }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            <a href="{{ $user->path() }}/edit">
                                <button type="submit" class="btn btn-outline-info"><i class="fa fa-edit"></i> </button>
                            </a>
                            @if($user->role_id != 2)
                                <a href="{{ $user->path() }}/makeEngineer">
                                    <button type="submit" class="btn btn-outline-danger"> Make Engineer</button>
                                </a>
                            @elseif($user->role_id == 2 and auth()->id() != $user->id)
                                <a href="{{ $user->path() }}/makeUser">
                                    <button type="submit" class="btn btn-outline-dark"> Make User</button>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $allUsers->links() }}
        </div>
    </div>

@endsection
