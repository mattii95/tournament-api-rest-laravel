<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Tournament;
use Illuminate\Database\Seeder;
use App\Services\TournamentService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TournamentSeeder extends Seeder
{
    public function run(): void
    {
        Tournament::factory()->count(4)->create([
            'gender' => 'man',
            'players_amount' => 16,
        ]);
        
        Tournament::factory()->count(4)->create([
            'gender' => 'woman',
            'players_amount' => 16,
        ]);
    }
}
