@component('mail::message')

<strong>Ticket Number:</strong> {{ $ticket->id }}

<strong>Subject:</strong> {{ $ticket->subject }}

<strong>Content:</strong> {{ $ticket->body }}

<strong>Created By:</strong> {{ $ticket->creator->firstname }} {{ $ticket->creator->lastname }} ({{ $ticket->creator->email }})

@component('mail::button', ['url' => 'http://helpdesk.appp/tickets/'. $ticket->id])
    View Ticket
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
