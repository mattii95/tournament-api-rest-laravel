<?php

namespace App\Models;

use App\Models\Tournament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'gender',
        'skill_level',
        'strength',
        'speed',
        'reaction_time',
        'tournament_id'
    ];

    public function tournament() {
        return $this->belongsTo(Tournament::class);
    }
}
