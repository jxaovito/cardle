<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class SearchController extends Controller{

    public function index(Request $request){
    $query = $request->input('q');
    $game = new Game;
    $results = $game->search($query);

    return response()->json($results);
}



}
