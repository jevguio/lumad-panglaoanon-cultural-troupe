<?php
use Carbon\Carbon;
use App\Models\Event;
use Illuminate\Console\Command;

class SendEventReminders extends Command
{
    protected $signature = 'events:send-reminders';
    protected $description = 'Send reminders to selected performers';

    public function handle()
    {
        $today = Carbon::today();

        // Number of days before event to start countdown
        $countdownDays = [3, 2, 1]; // you can adjust

        $events = Event::with(['performers' => function($q) {
                $q->where('event_user.status', 'selected');
            }])
            ->get();

        foreach ($events as $event) {
            $eventDate = Carbon::parse($event->date);
            $diffDays = $today->diffInDays($eventDate, false); // negative if past

            foreach ($event->performers as $user) {
                if (in_array($diffDays, $countdownDays)) {
                    // Countdown reminder
                    $user->notify(new \App\Notifications\EventCountdownNotification($event, $diffDays));
                } elseif ($diffDays === 0) {
                    // Today reminder
                    $user->notify(new \App\Notifications\EventTodayNotification($event));
                }
            }
        }

        $this->info('Reminders sent successfully!');
    }
}
