<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller{
    public function index(){
        $array = [
            ['id' => 1, 'title' => 'Valhalla', 'content' => '123'],
            ['id' => 2, 'title' => 'Wurstopia', 'content' => '3'],
            ['id' => 3, 'title' => 'Brandon', 'content' => '789'],
        ];

        usort($array, function ($a, $b){
            return strcmp($a['title'], $b['title']);
        }); 

        // Aqui você pode adicionar a lógica para filtrar os resultados com base na pesquisa

        return view('game');
    }
}