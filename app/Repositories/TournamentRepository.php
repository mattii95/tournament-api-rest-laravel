<?php

namespace App\Repositories;

use App\Models\Tournament;
use App\Http\Resources\PlayerResource;
use App\Http\Resources\TournamentResource;
use App\Interfaces\TournamentRepositoryIntarface;

class TournamentRepository implements TournamentRepositoryIntarface {

    public function index() {
        $select = Tournament::select(
                'tournaments.id', 
                'tournaments.name', 
                'tournaments.created_at', 
                'tournaments.gender', 
                'tournaments.players_amount', 
                'tournaments.player_id',
                'players.name as winner_name',
                'players.id as winner_id',
                'players.skill_level',
                'players.strength',
                'players.speed',
                'players.reaction_time'
        )->leftJoin('players', 'players.id', '=', 'tournaments.player_id')->get();
        return TournamentResource::collection($select);
    }

    public function create(array $data) {
        $tournament = new Tournament();
        $tournament->name = $data['name'];
        $tournament->gender = $data['gender'];
        $tournament->players_amount = intval($data['players_amount']);
        $tournament->created_at = now();
        $tournament->save();
        return new TournamentResource($tournament);
    }  

    public function show(Tournament $tournament) {
        $select = Tournament::select(
            'tournaments.id', 
            'tournaments.name', 
            'tournaments.created_at', 
            'tournaments.gender', 
            'tournaments.players_amount', 
            'tournaments.player_id',
            'players.name as winner_name',
            'players.id as winner_id',
            'players.skill_level',
            'players.strength',
            'players.speed',
            'players.reaction_time'
        )->leftJoin('players', 'players.id', '=', 'tournaments.player_id')
        ->where('tournaments.id', $tournament->id)
        ->get();
        return TournamentResource::collection($select);
    }

    public function update(array $data, Tournament $tournament) {
        $tournament->update($data);
        return new TournamentResource($tournament);
    }

    public function delete(Tournament $tournament) {
        return $tournament->delete();
    }

    public function getTournamentPlayers(Tournament $tournament) {
        return PlayerResource::collection($tournament->players);
    }

    public function filter(array $data) {
        $query = Tournament::query();

        $query->select(
            'tournaments.id', 
            'tournaments.name', 
            'tournaments.created_at', 
            'tournaments.gender', 
            'tournaments.players_amount', 
            'tournaments.player_id',
            'players.name as winner_name',
            'players.id as winner_id',
            'players.skill_level',
            'players.strength',
            'players.speed',
            'players.reaction_time'
        )->leftJoin('players', 'players.id', '=', 'tournaments.player_id');

        if (array_key_exists('start_date', $data) && (array_key_exists('end_date', $data))) {
            $query->whereBetween('tournaments.created_at', [$data['start_date'], $data['end_date']]);
        }

        if (array_key_exists('gender', $data)) {
            $query->where('tournaments.gender', $data['gender']);
        }
        
        if (array_key_exists('has_winner', $data)) {
            if ($data['has_winner']) {
                $query->whereNotNull('tournaments.player_id');
            }
        }
        
        $tournaments = $query->get();

        return TournamentResource::collection($tournaments);
    }
}