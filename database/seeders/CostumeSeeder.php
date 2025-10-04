<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Costume;
class CostumeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Costume::create([
            'name' => 'Costume 1',
            'user_id' => 1,
            'status' => 'pending',
            'date_returned' => '2025-08-12',
            'date_lost' => null,
            'date_complied' => null,
        ]);

        Costume::create([
            'name' => 'Costume 2',
            'user_id' => 2,
            'status' => 'returned',
            'date_returned' => null,
            'date_lost' => '2025-08-09',
            'date_complied' => '2025-08-12',
        ]);

        Costume::create([
            'name' => 'Costume 3',
            'user_id' => 2,
            'status' => 'lost',
            'date_returned' => '2025-08-12',
            'date_lost' => null,
            'date_complied' => null,
        ]);
    }
}
