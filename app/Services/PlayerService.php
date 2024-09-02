<?php

namespace App\Services;

use App\Models\Player;
use App\Helpers\ApiResponseHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PlayerResource;
use App\Interfaces\PlayerRepositoryInterface;

class PlayerService {

    protected $playerRepositoryInterface;

    public function __construct(PlayerRepositoryInterface $playerRepositoryInterface) {
        $this->playerRepositoryInterface = $playerRepositoryInterface;
    }

    public function index() {
        $result = $this->playerRepositoryInterface->index();
        return ApiResponseHelper::sendResponse(PlayerResource::collection($result));
    }   

    public function create(array $data) {
        $tournament = $this->playerRepositoryInterface->getTournament($data['tournament_id']);
        $players = $this->playerRepositoryInterface->getPlayersByTournament($data['tournament_id']);

        if ($data['gender'] !== $tournament->gender) {
            $message =  $tournament->gender === 'man' 
                ? "El torneo es para genero masculino." 
                : "El torneo es para genero femenino.";
            return ApiResponseHelper::sendResponse($message, '', 400);
        }

        if (count($players) >= intval($tournament->players_amount)) {
            return ApiResponseHelper::sendResponse('El torneo esta completo', '', 400);
        }

        DB::beginTransaction();
        try {
            $result = $this->playerRepositoryInterface->create($data);
            DB::commit();
            return ApiResponseHelper::sendResponse($result, 'Player create succesful', 201);
        } catch (\Exception $ex) {
            return ApiResponseHelper::rollback($ex);
        }
    }   

    public function show(Player $player) {
        $result = $this->playerRepositoryInterface->show($player);
        return ApiResponseHelper::sendResponse(PlayerResource::collection($result));
    }

    public function update(array $data, Player $player) {
        $tournament = $this->playerRepositoryInterface->getTournament($data['tournament_id']);

        if ($data['gender'] !== $tournament->gender) {
            $message =  $tournament->gender === 'man' 
                ? "El torneo es para genero masculino." 
                : "El torneo es para genero femenino.";
            return ApiResponseHelper::sendResponse($message, '', 400);
        }

        DB::beginTransaction();
        try {
            $result = $this->playerRepositoryInterface->update($data, $player);
            DB::commit();
            return ApiResponseHelper::sendResponse($result, 'Player updated succesful', 200);
        } catch (\Exception $ex) {
            return ApiResponseHelper::rollback($ex);
        }
    }
    
    public function delete(Player $player) {
        DB::beginTransaction();
        try {
            $result = $this->playerRepositoryInterface->delete($player);
            DB::commit();
            return ApiResponseHelper::sendResponse($result, 'Player deleted succesful', 200);
        } catch (\Exception $ex) {
            return ApiResponseHelper::rollback($ex);
        }
    }
}