<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Game extends Model
{
    use HasFactory;

    protected $table = 'carros';
    public $tries = [];
    public $generatedCar;
    
    public function __construct()
    {
    }

    public function search($query){
        return $this->where('modelo', 'like', "%{$query}%")->get();
    }
    
}
