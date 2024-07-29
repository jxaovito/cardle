<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

// Route::get('/game', 'App\Http\Controllers\GameController@index', function(){
//     return view('game', ['car_of_the_day' => $car]);
// });
// Rota para exibir a view
Route::get('/game', [GameController::class, 'show'])->name('game.show');

// Rota para a requisição AJAX
Route::get('/random-car-image', [GameController::class, 'index']);
Route::post('/search', 'App\Http\Controllers\SearchController@index');
Route::post('/try', 'App\Http\Controllers\SearchController@try');
// Route::get('/random-car-image', 'YourController@index');
