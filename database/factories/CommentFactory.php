<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'content'=> $this->faker->paragraph,
            'user_id'=> User::all()->random(1)->first(),
            'post_id'=> Post::all()->random(1)->first(),
        ];
    }
}
