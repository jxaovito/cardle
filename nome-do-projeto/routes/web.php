<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

// Route::get('/game', 'App\Http\Controllers\GameController@index', function(){
//     return view('game', ['car_of_the_day' => $car]);
// });
Route::get('/game', [GameController::class, 'index'])->name('random.game');
Route::post('/search', 'App\Http\Controllers\SearchController@index');
Route::post('/try', 'App\Http\Controllers\SearchController@try');