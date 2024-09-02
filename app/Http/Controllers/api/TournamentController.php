<?php

namespace App\Http\Controllers\api;

use App\Models\Tournament;
use App\Services\TournamentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tournament\StoreRequest;
use App\Http\Requests\Tournament\FilterRequest;
use App\Http\Requests\Tournament\UpdateRequest;

/**
 * @OA\Tag(
 *     name="Tournaments",
 *     description="API Endpoints for Tournaments"
 * )
 */
class TournamentController extends Controller
{
    private TournamentService $tournamentService;

    public function __construct(TournamentService $tournamentService) {
        $this->tournamentService = $tournamentService;
    }

    /**
     * @OA\Get(
     *     path="/api/tournament",
     *     tags={"Tournament"},
     *     summary="Get list of Tournaments",
     *     description="Returns a list of Tournaments",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *           type="array", 
     *           @OA\Items(ref="#/components/schemas/TournamentResource")
     *         )
     *     )
     * )
     */
    public function index() {
        return  $this->tournamentService->index();
    }
    
    /**
     * @OA\Post(
     *     path="/api/tournament",
     *     tags={"Tournament"},
     *     summary="Create a new tournament",
     *     description="Creates a new tournament and returns the created tournament data",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *           ref="#/components/schemas/TournamentResource",
     *           example={
     *              "name": "Tennis",
     *              "created_at": "30-08-2024",
     *              "gender": "woman",
     *              "players_amount": 16,
     *              "player_id": null
     *           }
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tournament created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/TournamentResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(type="string", example="Invalid input")
     *     )
     * )
     */
    public function store(StoreRequest $request) {
        return $this->tournamentService->create($request->validated());
    }

    /**
     * @OA\Get(
     *     path="/api/tournament/{tournament}",
     *     tags={"Tournament"},
     *     summary="Get tournament by Id",
     *     description="Returns a tournament by Id",
     *     @OA\Parameter(
     *         name="tournament",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/TournamentResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Player not found"
     *     )
     * )
     */
    public function show(Tournament $tournament) {
        return $this->tournamentService->show($tournament);
    }

    /**
     * @OA\Put(
     *   tags={"Tournament"},
     *   path="/api/tournament/{tournament}",
     *   summary="Tournament update",
     *   @OA\Parameter(
     *       name="tournament",
     *       in="path",
     *       required=true,
     *       @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(
     *         ref="#/components/schemas/TournamentResource",
     *         example={
     *            "name": "Tennis",
     *            "created_at": "30-08-2024",
     *            "gender": "woman",
     *            "players_amount": 16,
     *            "player_id": 2
     *         }
     *       )
     *    ),
     *   @OA\Response(
     *       response=200,
     *       description="Tournament updated successfully",
     *       @OA\JsonContent(ref="#/components/schemas/TournamentResource")
     *   ),
     *   @OA\Response(
     *       response=400,
     *       description="Bad request",
     *       @OA\JsonContent(type="string", example="Invalid input")
     *   ),
     *   @OA\Response(response=404, description="Not Found"),
     * )
     */
    public function update(UpdateRequest $request, Tournament $tournament) {
        return $this->tournamentService->update($request->validated(), $tournament); 
    }

    /**
     * @OA\Delete(
     *   path="/api/tournament/{tournament}",
     *   tags={"Tournament"},
     *   summary="Delete tournament by Id",
     *   description="Returns boolean: true or false",
     *   @OA\Parameter(
     *       name="tournament",
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
     *       description="Not found"
     *   )
     * )
     */
    public function delete(Tournament $tournament) {
        return $this->tournamentService->delete($tournament);
    }

    /**
     * @OA\Get(
     *     path="/api/tournament/players/{tournament}",
     *     tags={"Tournament"},
     *     summary="Get players by tournament_id",
     *     description="Returns a players by tournament_id",
     *     @OA\Parameter(
     *         name="tournament",
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
     *         description="Players not found"
     *     )
     * )
     */
    public function getTournamentPlayers(Tournament $tournament) {
        return $this->tournamentService->getTournamentPlayers($tournament);
    }

    /**
     * @OA\Get(
     *   path="/api/tournament/filter",
     *   tags={"Tournament"},
     *   summary="Get tournaments",
     *   @OA\Parameter(
     *      name="start_date",
     *      in="query",
     *      required=false,
     *      @OA\Schema(type="date")
     *   ),
     *   @OA\Parameter(
     *      name="end_date",
     *      in="query",
     *      required=false,
     *      @OA\Schema(type="date")
     *   ),
     *   @OA\Parameter(
     *      name="gender",
     *      in="query",
     *      required=false,
     *      @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *      name="has_winner",
     *      in="query",
     *      required=false,
     *      @OA\Schema(type="boolean")
     *   ),
     *   @OA\Response(
     *       response=200,
     *       description="Successful operation",
     *       @OA\JsonContent(
     *         type="array", 
     *         @OA\Items(ref="#/components/schemas/TournamentResource")
     *       )
     *   ),
     *   @OA\Response(response=404, description="Not Found")
     * )
     */
    public function filter(FilterRequest $request) {
        return  $this->tournamentService->filter($request->validated());
    }

    /**
     * @OA\Get(
     *     path="/api/tournament/simulate/{tournament}",
     *     tags={"Tournament"},
     *     summary="Get simulate tournament by tournament_id",
     *     description="Returns a simulate tournament by tournament_id",
     *     @OA\Parameter(
     *         name="tournament",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Players not found"
     *     )
     * )
     */
    public function simulate(Tournament $tournament) {
        return $this->tournamentService->simulateTournament($tournament);
    }
}
