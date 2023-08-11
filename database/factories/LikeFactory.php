<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    public function definition(): array
    {
        return [
            "is_liked" => $this->faker->boolean,
            "post_id" => Post::all()->random()->first(),
            "user_id" => User::all()->random()->first(),
            "liked_at"=> $this->faker->dateTime(),
        ];
    }
}
