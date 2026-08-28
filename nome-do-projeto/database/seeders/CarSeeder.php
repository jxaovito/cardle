<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarSeeder extends Seeder
{
    public function run()
    {
        DB::table('carros')->insert([
            [
                'modelo' => '718 Spyder RS',
                'marca' => 'Porsche',
                'carroceria' => 'Roadster',
                'motor' => 4.0,
                'ano_lancamento' => 2023,
                'peso' => 1415,
                'foto' => 'img/718-spyder-rs.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'modelo' => 'TTS',
                'marca' => 'Audi',
                'carroceria' => 'Coupe',
                'motor' => 2.0,
                'ano_lancamento' => 2019,
                'peso' => 1395,
                'foto' => 'img/audi-tts.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'modelo' => 'Carrera GT',
                'marca' => 'Porsche',
                'carroceria' => 'Roadster',
                'motor' => 5.7,
                'ano_lancamento' => 2004,
                'peso' => 1380,
                'foto' => 'img/carrera-gt.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'modelo' => 'M3',
                'marca' => 'BMW',
                'carroceria' => 'Sedan',
                'motor' => 3.0,
                'ano_lancamento' => 2021,
                'peso' => 1730,
                'foto' => 'img/m3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'modelo' => 'M5',
                'marca' => 'BMW',
                'carroceria' => 'Sedan',
                'motor' => 4.4,
                'ano_lancamento' => 2021,
                'peso' => 2015,
                'foto' => 'img/m5.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'modelo' => 'RS4 Avant',
                'marca' => 'Audi',
                'carroceria' => 'Avant',
                'motor' => 2.9,
                'ano_lancamento' => 2023,
                'peso' => 1835,
                'foto' => 'img/rs4.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'modelo' => 'RS7 Sportback',
                'marca' => 'Audi',
                'carroceria' => 'Fastback',
                'motor' => 4.0,
                'ano_lancamento' => 2020,
                'peso' => 2085,
                'foto' => 'img/rs7.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'modelo' => 'X5 M Competition',
                'marca' => 'BMW',
                'carroceria' => 'SUV',
                'motor' => 4.4,
                'ano_lancamento' => 2020,
                'peso' => 2285,
                'foto' => 'img/x5.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
