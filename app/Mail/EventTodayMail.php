<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventTodayMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

     public $event;

     public function __construct($event)
     {
         $this->event = $event;
     }
 
     public function build()
     {
         return $this->subject("Today is your Event: {$this->event->title}")
                     ->view('emails.event_today'); // create this Blade
     }
    /**
     * Get the message envelope.
     */ 

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
