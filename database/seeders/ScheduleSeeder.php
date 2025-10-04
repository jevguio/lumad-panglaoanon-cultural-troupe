<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        Schedule::create([
            'event_id'      => 'Event 1',
            'event_details' => 'Cultural Dance Festival'
        ]);

        Schedule::create([
            'event_id'      => 'Event 2',
            'event_details' => 'Heritage Parade'
        ]);
    }
}
