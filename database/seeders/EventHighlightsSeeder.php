<?php

namespace Database\Seeders;

use App\Models\EventHighlights;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventHighlightsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        
        EventHighlights::create([
            'name' => 'Costume 1',
            'user_id' => 1,
            'status' => 'pending',
            'date_returned' => '2025-08-12',
            'date_lost' => null,
            'date_complied' => null,
        ]);

    }
}
