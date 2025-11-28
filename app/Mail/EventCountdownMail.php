<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventCountdownMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

     public $event;
     public $daysLeft;
     public function __construct($event, $daysLeft)
     {
         $this->event = $event;
         $this->daysLeft = $daysLeft;
     }

    /**
     * Get the message envelope.
     */ 

    public function build()
    {
        return $this->subject("Event Reminder: {$this->event->title}")
                    ->view('emails.event_countdown'); // create this Blade
    }
    /**
     * Get the message content definition.
     */ 
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
