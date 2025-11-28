<?php

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventTodayNotification extends Notification
{
    protected $event;

    public function __construct($event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Today is your Event: {$this->event->title}")
            ->line("Today is your event '{$this->event->title}'.")
            ->line("Venue: {$this->event->venue}")
            ->line("Time: {$this->event->time}")
            ->line('Make sure you are on time and prepared!');
    }
}
