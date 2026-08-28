<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q', '');

        if (strlen($query) < 1) {
            return response()->json([]);
        }

        $results = Game::search($query)->get();

        return response()->json($results);
    }
}
