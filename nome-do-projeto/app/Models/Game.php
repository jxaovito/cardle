<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $table = 'carros';

    protected $casts = [
        'motor' => 'float',
        'ano_lancamento' => 'integer',
        'peso' => 'integer',
    ];

    public function scopeSearch($query, $term)
    {
        return $query->where('modelo', 'like', "%{$term}%")
                     ->orWhere('marca', 'like', "%{$term}%");
    }

    public static function compare(Game $guessed, Game $daily): array
    {
        if ($guessed->id === $daily->id) {
            return ['won' => true, 'guessedCar' => $guessed];
        }

        return [
            'won' => false,
            'guessedCar' => $guessed,
            'comparison' => [
                'marca' => [
                    'result' => $guessed->marca === $daily->marca ? 'correct' : 'wrong',
                ],
                'carroceria' => [
                    'result' => $guessed->carroceria === $daily->carroceria ? 'correct' : 'wrong',
                ],
                'motor' => [
                    'result' => $guessed->motor == $daily->motor
                        ? 'correct'
                        : ($guessed->motor < $daily->motor ? 'low' : 'high'),
                ],
                'ano_lancamento' => [
                    'result' => $guessed->ano_lancamento == $daily->ano_lancamento
                        ? 'correct'
                        : ($guessed->ano_lancamento < $daily->ano_lancamento ? 'low' : 'high'),
                ],
                'peso' => [
                    'result' => $guessed->peso == $daily->peso
                        ? 'correct'
                        : ($guessed->peso < $daily->peso ? 'low' : 'high'),
                ],
            ],
        ];
    }
}
