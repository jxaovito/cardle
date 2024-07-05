<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/game', 'App\Http\Controllers\GameController@index');
Route::post('/search', 'App\Http\Controllers\SearchController@index');
Route::post('/try', 'App\Http\Controllers\SearchController@try');