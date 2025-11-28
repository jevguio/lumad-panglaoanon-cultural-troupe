<?php

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Illuminate\Bus\Queueable;
class EventCountdownNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $event;

    protected $daysLeft;

    public function __construct($event, $daysLeft)
    {
        $this->event = $event;
        $this->daysLeft = $daysLeft;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Event Reminder: {$this->event->title}")
            ->line("Your event '{$this->event->title}' is in {$this->daysLeft} day(s).")
            ->line("Venue: {$this->event->venue}")
            ->line("Date: {$this->event->date}")
            ->line("Time: {$this->event->time}")
            ->line('Please prepare accordingly!');
    }
}
