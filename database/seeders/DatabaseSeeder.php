<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Comment;
use App\Models\Message;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'nika',
            'email' => 'nika@nika.com',
            'password' => bcrypt('nikanika'),
        ]);

        User::factory(5)->create();
        Post::factory(10)->create();

        Message::factory(10)->create();
        Comment::factory(10)->create();
    }
}
