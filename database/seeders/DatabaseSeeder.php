<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Message;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->admin()->create([
            'name' => 'nika',
            'email' => 'nika@nika.com',
            'password' => bcrypt('nikanika'),
        ]);
        \App\Models\User::factory()->admin()->create([
            'name' => 'nika1',
            'email' => 'nika1@nika.com',
            'password' => bcrypt('nikanika'),
        ]);

        Message::factory(10)->create();
    }
}
