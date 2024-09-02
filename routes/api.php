<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\PlayerController;
use App\Http\Controllers\api\TournamentController;

Route::get('/tournament', [TournamentController::class, 'index']);
Route::post('/tournament', [TournamentController::class, 'store']);
Route::get('/tournament/filter', [TournamentController::class, 'filter']);
Route::get('/tournament/players/{tournament}', [TournamentController::class, 'getTournamentPlayers']);
Route::get('/tournament/simulate/{tournament}', [TournamentController::class, 'simulate']);
Route::get('/tournament/{tournament}', [TournamentController::class, 'show']);
Route::put('/tournament/{tournament}', [TournamentController::class, 'update']);
Route::delete('/tournament/{tournament}', [TournamentController::class, 'delete']);

Route::get('/player', [PlayerController::class, 'index']);
Route::post('/player', [PlayerController::class, 'store']);
Route::get('/player/{player}', [PlayerController::class, 'show']);
Route::put('/player/{player}', [PlayerController::class, 'update']);
Route::delete('/player/{player}', [PlayerController::class, 'delete']);
