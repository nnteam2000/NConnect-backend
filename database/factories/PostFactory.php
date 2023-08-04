<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'content' => $this->faker->text(100),
            'user_id' => User::all()->random()->id,
            'image' => $this->faker->imageUrl(640, 480, 'animals', true),
        ];
    }
}
