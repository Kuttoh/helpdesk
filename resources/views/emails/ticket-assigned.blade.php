@component('mail::message')

<strong>Ticket Number:</strong> {{ $ticket->id }}

<strong>Subject:</strong> {{ $ticket->subject }}

<strong>Content:</strong> {{ $ticket->body }}

<strong>Assigned To:</strong> {{ $ticket->assignedTo->firstname }} {{ $ticket->assignedTo->lastname }}

@component('mail::button', ['url' => 'http://helpdesk.appp/tickets/'. $ticket->id])
View Ticket
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
