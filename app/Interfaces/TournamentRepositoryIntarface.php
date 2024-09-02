<?php

namespace App\Interfaces;

use App\Models\Tournament;

interface TournamentRepositoryIntarface
{
    public function index();
    public function create(array $data);
    public function show(Tournament $tournament);
    public function update(array $data, Tournament $tournament);
    public function delete(Tournament $tournament);
    public function getTournamentPlayers(Tournament $tournament);
    public function filter(array $data);
}
