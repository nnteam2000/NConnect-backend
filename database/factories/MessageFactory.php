<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'content' => $this->faker->sentence,
            "sender_id" => User::all()->random(1)->first(),
            "receiver_id" => User::all()->random(1)->first(),
        ];
    }
}
