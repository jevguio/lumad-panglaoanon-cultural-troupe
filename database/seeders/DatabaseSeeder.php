<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'performer User',
        //     'email' => 'test@troupesync.com',
        //     'type'=>'user'
        // ]);

        User::updateOrCreate(
            ['email' => 'info@troupesync.com'], // condition
            [
                'name' => 'Performer User',
                'type' => 'admin',
                'password' => Hash::make('Troupesync_2025'), // change this
            ]
        );
        // // $this->call([
        //     CostumeSeeder::class,
        //     EventSeeder::class,
        // ]);
    }
}
