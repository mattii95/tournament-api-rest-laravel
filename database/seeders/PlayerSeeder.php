<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Tournament;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlayerSeeder extends Seeder
{
    public function run(): void
    {
        $tournaments = Tournament::all();
        foreach ($tournaments as $tournament) {
            Player::factory()->count(16)->create(['tournament_id' => $tournament->id]);
        }
    }
}
