@component('mail::message')
## Ticket Number: {{ $ticket->id }} has a comment

Comment: {{ $reply->body }}

@component('mail::button', ['url' => 'http://helpdesk.appp/tickets/'. $ticket->id])
    View Ticket
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
