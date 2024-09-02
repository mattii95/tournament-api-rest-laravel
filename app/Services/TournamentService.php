<?php

namespace App\Services;

use App\Models\Player;
use App\Models\Tournament;
use App\Helpers\ApiResponseHelper;
use Illuminate\Support\Facades\DB;
use App\Interfaces\TournamentRepositoryIntarface;

class TournamentService {
    private TournamentRepositoryIntarface $tournamentRepositoryIntarface;

    public function __construct(TournamentRepositoryIntarface $tournamentRepositoryIntarface) {
        $this->tournamentRepositoryIntarface = $tournamentRepositoryIntarface;
    }

    public function index() {
        $result = $this->tournamentRepositoryIntarface->index();
        return ApiResponseHelper::sendResponse($result); 
    }

    public function create(array $data) {
        DB::beginTransaction();
        try {
            $result = $this->tournamentRepositoryIntarface->create($data);
            DB::commit();
            return ApiResponseHelper::sendResponse($result, 'Tournament create succesful', 201);
        } catch (\Exception $ex) {
            return ApiResponseHelper::rollback($ex);
        }
    }   

    public function show(Tournament $tournament) {
        $result = $this->tournamentRepositoryIntarface->show($tournament);
        return ApiResponseHelper::sendResponse($result); 
    }

    public function update(array $data, Tournament $tournament) {
        DB::beginTransaction();
        try {
            $result = $this->tournamentRepositoryIntarface->update($data, $tournament);
            DB::commit();
            return ApiResponseHelper::sendResponse($result, 'Tournament updated succesful', 200);
        } catch (\Exception $ex) {
            return ApiResponseHelper::rollback($ex);
        }
    }

    public function delete(Tournament $tournament) {
        DB::beginTransaction();
        try {
            $result = $this->tournamentRepositoryIntarface->delete($tournament);
            DB::commit();
            return ApiResponseHelper::sendResponse($result, 'Tournament deleted succesful', 200);
        } catch (\Exception $ex) {
            return ApiResponseHelper::rollback($ex);
        }
    }

    public function getTournamentPlayers(Tournament $tournament) {
        $result = $this->tournamentRepositoryIntarface->getTournamentPlayers($tournament);
        return ApiResponseHelper::sendResponse($result); 
    }

    public function filter(array $data) {
        $result = $this->tournamentRepositoryIntarface->filter($data);
        return ApiResponseHelper::sendResponse($result); 
    }

    public function simulateTournament(Tournament $tournament) {
        $players = $tournament->players;

        if (!is_null($tournament->player_id)) {
            return ApiResponseHelper::sendResponse('El torneo ya fue realizado', '', 400);
        }
        
        if ($players->count() <= 1) {
            return ApiResponseHelper::sendResponse('El torneo debe tener mas de 2 jugadores', '', 400);
        }

        $result = $this->simulateRound($players, $tournament->gender);

        if (is_null($result['winner']['id'])) {
            return ApiResponseHelper::sendResponse('No existe un ganador', '', 400);
        }

        DB::beginTransaction();
        try {
            $this->tournamentRepositoryIntarface->update(['player_id' => $result['winner']['id']], $tournament);
            DB::commit();
            return ApiResponseHelper::sendResponse($result, 'Simulate succesful', 200);
        } catch (\Exception $ex) {
            return ApiResponseHelper::rollback($ex);
        }

    }

    private function simulateRound($players, $gender) {
        $rounds = [];
        $currentRound = 1;
        $winner = [];
        while ($players->count() > 1) {
            $phase = [
                'phase' => $currentRound,
                'matches' => [],
                'winners' => []
            ];
            $nextRoundPlayers = [];
            for ($i=0; $i < $players->count(); $i+=2) { 
                $player1 = $players[$i];
                $player2 = $players[$i+1] ?? null;
                if ($player2) {
                    if ($gender === 'man') {
                        $winner = $this->winnerManPlayer($player1, $player2);
                    } else if ($gender === 'woman') {
                        $winner = $this->winnerWomanPlayer($player1, $player2);
                    }
                    $phase['matches'][] = [
                        'player1' => $player1,
                        'player2' => $player2,
                        'winner' => $winner
                    ];
                    $nextRoundPlayers[] = $winner;
                    $phase['winners'][] = $winner;
                }
            }
            $rounds['phases'][] = $phase;
            $players = collect($nextRoundPlayers);
            $winner = $nextRoundPlayers;
            $currentRound++;
        }  

        $rounds['phases'][] = [
            'phase' => 'Final',
            'winner' => $players->first(),
        ];

        $rounds['winner'] = $winner[0];

        return $rounds;
    }

    private function winnerManPlayer(Player $player1, Player $player2) : Player{
        $socore1 = $player1->strength + $player1->speed + rand(0, 100);
        $socore2 = $player2->strength + $player2->speed + rand(0, 100);
        return $socore1 >= $socore2 ? $player1 : $player2;
    }
    
    private function winnerWomanPlayer(Player $player1, Player $player2) : Player{
        $socore1 = $player1->reaction_time + rand(0, 100);
        $socore2 = $player2->reaction_time + rand(0, 100);
        return $socore1 >= $socore2 ? $player1 : $player2;
    }
}