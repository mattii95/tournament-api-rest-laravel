<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\Factory;


class PlayerFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'skill_level' => $this->faker->numberBetween(0, 100),
            'gender' => 'man',
            'strength' => null,
            'speed' => null,
            'reaction_time' => null,
            'tournament_id' => Tournament::factory()
        ];
    }

    public function configure() : self {
        return $this->afterMaking(function(Player $player) {
            $tournament = $player->tournament;
            if ($tournament && $tournament->gender === 'man') {
                $player->name = $this->faker->firstNameMale;
                $player->gender = 'man';
                $player->strength = $this->faker->numberBetween(0, 100);
                $player->speed = $this->faker->numberBetween(0, 100);
            } else if ($tournament && $tournament->gender === 'woman') {
                $player->name = $this->faker->firstNameFemale;
                $player->gender = 'woman';
                $player->reaction_time = $this->faker->numberBetween(0, 100);
            }
        });
    }
}
