<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tournament;
use Illuminate\Database\Seeder;
use Database\Seeders\PlayerSeeder;
use Illuminate\Support\Facades\DB;
use App\Services\TournamentService;
use Illuminate\Support\Facades\App;
use Database\Seeders\TournamentSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (App::environment('local')) {
            // Limpio los datos de las tablas
            DB::table('players')->truncate();
            DB::table('tournaments')->truncate();

            // Llamo los seeders
            $this->call(TournamentSeeder::class);
            $this->call(PlayerSeeder::class);

            // Simulo el torneo mediante un service
            $tournaments = Tournament::all();
            $service = app(TournamentService::class);
            foreach ($tournaments as $tournament) {
                $service->simulateTournament($tournament);
            }
        }
    }
}
