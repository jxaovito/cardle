<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    
    public function search($query){
        $results = DB::select('select * from users where id = :id', ['id' => 1]);
        return $results;
    }
    
}
