<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\SearchController;

Route::get('/', fn() => redirect('/game'));
Route::get('/game', [GameController::class, 'show'])->name('game.show');
Route::get('/random-car-image', [GameController::class, 'dailyCar']);
Route::get('/game-over', [GameController::class, 'gameOver']);
Route::post('/search', [SearchController::class, 'index']);
Route::post('/try', [GameController::class, 'attempt']);
