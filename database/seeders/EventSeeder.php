<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $event1 = Event::create([
            'title' => 'EVENT 1',
            'mode' => 'Show',
            'is_show_event' => true,
            'status' => 'available',
            'client' => 'Supreme Weddings',
            'venue' => 'Bohol Beach Club',
            'type' => 'Cultural',
            'date' => '2025-07-21',
            'time' => '19:00:00',
            'required_performers' => 15,
            'description' => 'Dances are Uyaoy, Ragragsakan, Chavacano, Bangko, Tinikling',
        ]);
        $event1->selectedPerformers()->attach([1, 2]); // performer user IDs

        // Event 2
        $event2 = Event::create([
            'title' => 'EVENT 2',
            'mode' => 'Show',
            'is_show_event' => true,
            'status' => 'available',
            'client' => 'Supreme Weddings',
            'venue' => 'Bohol Beach Club',
            'type' => 'Cultural',
            'date' => '2025-07-21',
            'time' => '19:00:00',
            'required_performers' => 15,
            'description' => 'Dances are Uyaoy, Ragragsakan, Chavacano, Bangko, Tinikling',
        ]);
        $event2->selectedPerformers()->attach([1, 2]);

        // Event 3
        $event3 = Event::create([
            'title' => 'EVENT 3',
            'mode' => 'Show',
            'is_show_event' => false,
            'status' => 'available',
            'client' => 'Supreme Weddings',
            'venue' => 'Bohol Beach Club',
            'type' => 'Cultural',
            'date' => '2025-07-21',
            'time' => '19:00:00',
            'required_performers' => 15,
            'description' => 'Dances are Uyaoy, Ragragsakan, Chavacano, Bangko, Tinikling',
        ]);
        $event3->selectedPerformers()->attach([1, 2]);
    }
}
