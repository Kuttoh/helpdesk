<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TicketRepliedTo extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket, $reply;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ticket, $reply)
    {
        $this->reply = $reply;

        $this->ticket = $ticket;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.ticket-replied-to');
    }
}
