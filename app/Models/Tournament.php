<?php

namespace App\Models;

use App\Models\Player;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tournament extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $fillable = [
        'name',
        'created_at',
        'gender',
        'players_amount',
        'player_id'
    ];

    public function players() {
        return $this->hasMany(Player::class);
    }

    public function winner() {
        return $this->belongsTo(Player::class);
    }
}
