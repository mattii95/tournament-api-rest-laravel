<?php

namespace Database\Factories;

use App\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\Factory;

class TournamentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company,
            'created_at' => $this->faker->dateTime,
            'gender' => $this->faker->randomElement(['man', 'woman']),
            'players_amount' => 16,
            'player_id' => null
        ];
    }
}
