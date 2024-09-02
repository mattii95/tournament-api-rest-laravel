<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
{
    /**
     * @OA\Schema(
     *      schema="PlayerResource",
     *      type="object",
     *      required={"name", "gender", "skill_level", "tournament_id"},
     *      @OA\Property(
     *          property="id",
     *          type="integer",
     *          example=1,
     *          description="ID of the Player"
     *      ),
     *      @OA\Property(
     *        property="name",
     *        type="string",
     *        example="Matt",
     *        description="Name of the Player"
     *      ),
     *      @OA\Property(
     *        property="gender",
     *        type="string",
     *        enum={"man", "woman"},
     *        example="man",
     *        description="Gender of the Player"
     *      ),
     *      @OA\Property(
     *        property="skill_level",
     *        type="integer",
     *        minimum=0,
     *        maximum=100,
     *        example=60,
     *        description="Player's skill level"
     *      ),
     *      @OA\Property(
     *        property="strength",
     *        type="integer",
     *        minimum=0,
     *        maximum=100,
     *        example=35,
     *        description="Player's strength"
     *      ),
     *      @OA\Property(
     *        property="speed",
     *        type="integer",
     *        minimum=0,
     *        maximum=100,
     *        example=45,
     *        description="Player's speed"
     *      ),
     *      @OA\Property(
     *        property="reaction_time",
     *        type="integer",
     *        minimum=0,
     *        maximum=100,
     *        example=null,
     *        description="Player's reaction time"
     *      ),
     *      @OA\Property(
     *        property="tournament_id",
     *        type="integer",
     *        example=1,
     *        description="Tournament's ID"
     *      )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name'=> $this->name, 
            'gender'=> $this->gender, 
            'skill_level'=> $this->skill_level,
            'strength'=> $this->strength,
            'speed'=> $this->speed,
            'reaction_time'=> $this->reaction_time,
            'tournament_id'=> $this->tournament_id
        ];
    }
}
