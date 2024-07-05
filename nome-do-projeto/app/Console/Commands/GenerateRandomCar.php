<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Game;
use Illuminate\Support\Facades\Cache;

class GenerateRandomCar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:randomcar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a random car';

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
        $car = '';
        
        $car = Game::inRandomOrder()->first();
        Cache::put('random_car', $car, now()->addDay());
    }  
}
