@component('mail::message')

You've been assigned a new role: <strong>{{ $user->role->name }}</strong>

Assigned by: <strong>{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</strong>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
