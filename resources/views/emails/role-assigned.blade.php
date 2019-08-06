@component('mail::message')

You've been assigned a new role: <strong>{{ $user->role->name }}</strong>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
