<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateRandomCar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
