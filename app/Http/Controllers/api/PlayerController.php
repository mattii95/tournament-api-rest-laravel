<?php

namespace App\Http\Controllers\api;

use App\Models\Player;
use App\Services\PlayerService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Player\StoreRequest;
use App\Http\Requests\Player\UpdateRequest;

/**
 * @OA\Tag(
 *     name="Players",
 *     description="API Endpoints for Players"
 * )
 */
class PlayerController extends Controller
{
    protected $playerService;

    public function __construct(PlayerService $playerService) {
        $this->playerService = $playerService;
    }

    /**
     * @OA\Get(
     *     path="/api/player",
     *     tags={"Players"},
     *     summary="Get list of players",
     *     description="Returns a list of players",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *           type="array", 
     *           @OA\Items(ref="#/components/schemas/PlayerResource")
     *         )
     *     )
     * )
     */
    public function index() {
        return $this->playerService->index();
    }
    
    /**
     * @OA\Post(
     *     path="/api/player",
     *     tags={"Players"},
     *     summary="Create a new player",
     *     description="Creates a new player and returns the created player data",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *           ref="#/components/schemas/PlayerResource",
     *           example={
     *              "name": "Jennifer",
     *              "gender": "woman",
     *              "skill_level": 63,
     *              "strength": null,
     *              "speed": null,
     *              "reaction_time": 74,
     *              "tournament_id": 2
     *           }
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Player created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/PlayerResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(type="string", example="Invalid input")
     *     )
     * )
     */
    public function store(StoreRequest $request) {
        return $this->playerService->create($request->validated());
    }

    /**
     * @OA\Get(
     *     path="/api/players/{player}",
     *     tags={"Players"},
     *     summary="Get player by Id",
     *     description="Returns a player by Id",
     *     @OA\Parameter(
     *         name="player",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PlayerResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Player not found"
     *     )
     * )
     */
    public function show(Player $player) {
        return $this->playerService->show($player);
    }

    /**
     * @OA\Put(
     *   tags={"Players"},
     *   path="/api/player/{player}",
     *   summary="Player update",
     *   @OA\Parameter(
     *       name="player",
     *       in="path",
     *       required=true,
     *       @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(
     *         ref="#/components/schemas/PlayerResource",
     *         example={
     *            "name": "Jennifer",
     *            "gender": "woman",
     *            "skill_level": 78,
     *            "strength": null,
     *            "speed": null,
     *            "reaction_time": 66,
     *            "tournament_id": 2
     *         }
     *       )
     *   ),
     *   @OA\Response(
     *       response=201,
     *       description="Player updated successfully",
     *       @OA\JsonContent(ref="#/components/schemas/PlayerResource")
     *   ),
     *   @OA\Response(
     *       response=400,
     *       description="Bad request",
     *       @OA\JsonContent(type="string", example="Invalid input")
     *   )
     * )
     */
    public function update(UpdateRequest $request, Player $player) {
        return $this->playerService->update($request->validated(), $player);
    }
    
    /**
     * @OA\Delete(
     *   path="/api/players/{player}",
     *   tags={"Players"},
     *   summary="Delete player by Id",
     *   description="Returns boolean: true or false",
     *   @OA\Parameter(
     *       name="player",
     *       in="path",
     *       required=true,
     *       @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *       response=200,
     *       description="Successful operation"
     *   ),
     *   @OA\Response(
     *       response=404,
     *       description="Player not found"
     *   )
     * )
     */
    public function delete(Player $player) {
        return $this->playerService->delete($player);
    }
}
