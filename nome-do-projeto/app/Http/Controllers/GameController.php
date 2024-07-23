<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GameController extends Controller{
    public $searchText;
    public $generatedCar;

    public function index(){
        $generatedCar = Cache::get('random_car');

        if(!$generatedCar){
            return view('game')->with('error', 'No generated car found in cache.');
        }

        return view('game', ['car_of_the_day' => $generatedCar]);
    }

    public function try($value){
        $generatedCar = Cache::get('random_car');
        $tries = [];
    
        if($value['id'] == $generatedCar['id']){
            return true;
        }
    
        $tries[0] = $value['modelo'] == $generatedCar->modelo ? 1 : 0;
        $tries[1] = $value['carroceria'] == $generatedCar->carroceria ? 1 : 0;
        $tries[2] = $value['motor'] == $generatedCar->motor ? 1 : ($value['motor'] < $generatedCar->motor ? 2 : 3);
        $tries[3] = $value['ano_lancamento'] == $generatedCar->ano_lancamento ? 1 : ($value['ano_lancamento'] < $generatedCar->ano_lancamento ? 2 : 3);
        $tries[4] = $value['peso'] == $generatedCar->peso ? 1 : ($value['peso'] < $generatedCar->peso ? 2 : 3);

        return $tries;   
    }
}