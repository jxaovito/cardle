<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $table = 'carros';
    
    public function search($query){
        return $this->where('modelo', 'like', "%{$query}%")->get();
    }
    
}
