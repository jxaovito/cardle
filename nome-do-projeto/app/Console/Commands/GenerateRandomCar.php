<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Game;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GenerateRandomCar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:randomcar';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(){        
        $car = Game::inRandomOrder()->first();
        if(is_null($car)){
            Log::warning('No car found to cache.');
            return Command::FAILURE;
        }else{  
            Cache::put('random_car', $car, now()->addDay());
            return Command::SUCCESS;
        }
    }  
}
