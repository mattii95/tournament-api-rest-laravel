<?php

namespace App\Interfaces;

use App\Models\Player;

interface PlayerRepositoryInterface
{
    public function index();
    public function create(array $data);
    public function show(Player $player);
    public function update(array $data, Player $player);
    public function delete(Player $player);
    public function getTournament(int $tournamnet_id);
    public function getPlayersByTournament(int $tournamnet_id);
}
