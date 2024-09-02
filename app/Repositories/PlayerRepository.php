<?php

namespace App\Repositories;

use App\Http\Resources\PlayerResource;
use App\Http\Resources\TournamentResource;
use App\Interfaces\PlayerRepositoryInterface;
use App\Models\Player;
use App\Models\Tournament;

class PlayerRepository implements PlayerRepositoryInterface {
    
    public function index() {
        $players = Player::all();
        return PlayerResource::collection($players);
    }

    public function create(array $data) {
        $player = new Player();
        $player->name = $data['name'];
        $player->gender = $data['gender'];
        $player->skill_level = $data['skill_level'];
        if (array_key_exists('strength', $data)) {
            $player->strength =  $data['strength'];
        }
        if (array_key_exists('speed', $data)) {
            $player->speed =  $data['speed'];
        }
        if (array_key_exists('reaction_time', $data)) {
            $player->reaction_time =  $data['reaction_time'];
        }
        $player->tournament_id = $data['tournament_id'];
        $player->save();
        return new PlayerResource($player);
    }

    public function show(Player $player) {
        $player =  Player::where('id', $player->id)->get();
        return PlayerResource::collection($player);
    }

    public function update(array $data, Player $player) {
        $player->update($data);
        return new PlayerResource($player);
    }

    public function delete(Player $player) {
        return $player->delete();
    }

    public function getTournament(int $tournament_id) {
        $tournament =  Tournament::where('id', $tournament_id)->first();
        return new TournamentResource($tournament);
    }
    
    public function getPlayersByTournament(int $tournament_id) {
        $players =  Player::where('tournament_id', $tournament_id)->get();
        return PlayerResource::collection($players);
    }

}