@component('mail::message')
#This Ticket has been assigned

## Subject: {{ $ticket->subject }}

{{ $ticket->body }}

@component('mail::button', ['url' => 'http://helpdesk.appp/tickets/'. $ticket->id])
View Ticket
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
