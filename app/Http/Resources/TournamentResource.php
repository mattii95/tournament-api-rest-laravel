<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TournamentResource extends JsonResource
{
    /**
     * @OA\Schema(
     *      schema="TournamentResource",
     *      type="object",
     *      required={"name", "created_at", "gender", "players_amount"},
     *      @OA\Property(
     *          property="id",
     *          type="integer",
     *          example=1,
     *          description="Tournament's ID"
     *      ),
     *      @OA\Property(
     *        property="name",
     *        type="string",
     *        example="Tennis",
     *        description="Tournament's Name"
     *      ),
     *      @OA\Property(
     *        property="created_at",
     *        type="date",
     *        example="30-09-2024",
     *        description="Tournament's Created"
     *      ),
     *      @OA\Property(
     *        property="gender",
     *        type="string",
     *        enum={"man", "woman"},
     *        example="man",
     *        description="Tournament's gender"
     *      ),
     *      @OA\Property(
     *        property="players_amount",
     *        type="integer",
     *        minimum=2,
     *        maximum=32,
     *        example=16,
     *        description="Tournament's players amount"
     *      ),
     *      @OA\Property(
     *        property="player_id",
     *        type="integer",
     *        example=1,
     *        description="Player's ID"
     *      ),
     *      @OA\Property(
     *        property="winner",
     *        type="object",
     *        nullable=true,
     *        description="Winner player info",
     *        @OA\Schema(ref="#/components/schemas/PlayerResource")
     *      )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name'=> $this->name, 
            'created_at'=> $this->created_at,
            'gender'=> $this->gender,
            'players_amount'=> $this->players_amount,
            'player_id'=> $this->player_id,
            'winner' => $this->player_id ? [
                'name' => $this->winner_name,
                'skill_level' => $this->skill_level,
                'strength' => $this->strength,
                'speed' => $this->speed,
                'reaction_time' => $this->reaction_time
            ] : null
        ];
    }
}
