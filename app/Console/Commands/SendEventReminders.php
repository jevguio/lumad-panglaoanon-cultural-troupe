<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use Carbon\Carbon;
use App\Notifications\EventReminderNotification;

class SendEventReminders extends Command
{
    protected $signature = 'events:send-reminders';
    protected $description = 'Send email reminders to assigned performers for tomorrow’s events';

    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $events = Event::where('date', $tomorrow)
            ->whereHas('performers', function ($q) {
                $q->where('event_user.status', 'selected');
            })
            ->with(['performers' => function ($q) {
                $q->where('event_user.status', 'selected');
            }])
            ->get();

        foreach ($events as $event) {
            foreach ($event->performers as $user) {
                $user->notify(new EventReminderNotification($event));
            }
        }

        $this->info("Reminders sent for tomorrow's events.");
    }
}
