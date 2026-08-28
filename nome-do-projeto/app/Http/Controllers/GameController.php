<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Game;

class GameController extends Controller
{
    public function show()
    {
        return view('game');
    }

    public function dailyCar()
    {
        $car = $this->getDailyCar();

        if (!$car) {
            return response()->json(['error' => 'Nenhum carro encontrado.'], 404);
        }

        return response()->json([
            'car_of_the_day' => ['foto' => $car->foto],
        ]);
    }

    public function attempt(Request $request)
    {
        $carId = $request->input('id');
        $guessed = Game::findOrFail($carId);
        $daily = $this->getDailyCar();

        if (!$daily) {
            return response()->json(['error' => 'Carro do dia não encontrado.'], 404);
        }

        return response()->json(Game::compare($guessed, $daily));
    }

    public function gameOver()
    {
        $car = $this->getDailyCar();

        if (!$car) {
            return response()->json(['error' => 'Nenhum carro encontrado.'], 404);
        }

        return response()->json([
            'marca' => $car->marca,
            'modelo' => $car->modelo,
            'foto' => $car->foto,
        ]);
    }

    private function getDailyCar(): ?Game
    {
        $cached = Cache::get('random_car');

        if ($cached instanceof Game) {
            return $cached;
        }

        // Cache miss or stale — pick a new random car
        $car = Game::inRandomOrder()->first();
        if ($car) {
            Cache::put('random_car', $car, now()->endOfDay());
        }

        return $car;
    }
}
