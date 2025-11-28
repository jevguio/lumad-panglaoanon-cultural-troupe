<?php
namespace App\Notifications;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Event $event) {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Event Reminder: ' . $this->event->title)
            ->greeting('Hi ' . $notifiable->name . '!')
            ->line('This is a reminder that you are assigned for an event tomorrow.')
            ->line('📅 Date: ' . $this->event->date)
            ->line('🕒 Time: ' . $this->event->time)
            ->line('📍 Venue: ' . $this->event->venue)
            ->line('📌 Role: Performer')
            ->line('Please be on time. God bless!');
    }
}
