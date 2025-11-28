<?php

namespace App\Console\Commands;

use App\Mail\EventCountdownMail;
use App\Mail\EventTodayMail;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEventReminders extends Command
{
    protected $signature = 'events:send-reminders';

    protected $description = 'Send reminders to selected performers';

    public function handle()
    {
        $today = Carbon::today();

        // Number of days before event to start countdown
        $countdownDays = [3, 2, 1]; // you can adjust

        $events = Event::with(['performers' => function ($q) {
            $q->where('event_user.status', 'selected');
        }])
            ->get();

        foreach ($events as $event) {
            $eventDate = Carbon::parse($event->date);
            $diffDays = $today->diffInDays($eventDate, false); // negative if past
            Log::info($diffDays);
            foreach ($event->performers as $user) {

                Log::info($user);
                if ($diffDays > 0) {
                    Mail::to($user->email)->send(new EventCountdownMail($event, $diffDays));
                    $this->info('Event Countdown Mail Reminders sent to '.$user->email.'!');
                } elseif ($diffDays === 0) {
                    Mail::to($user->email)->send(new EventTodayMail($event));
                    $this->info('Event Today Mail Reminders sent to '.$user->email.'!');
                }
            }
        }
        $this->info('Today Reminders sent!');

    }
}
