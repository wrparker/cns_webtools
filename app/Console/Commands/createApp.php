<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class createApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'createApp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically generates a new web application.';

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
     * @return mixed
     */
    public function handle()
    {
        //Come back to this...
        //
        $this->info("Welcome to the automatic app generator!");
        //Naming Scheme: FundingOpportunity
        $name = $this->ask("What is application name (singular)?");
        $names = $this->ask("What is application name (plural) ?");

        //1. Create the model and Controller.
        $controllerName = app_path().'/Http/Controllers/'.$name.'Controller.php';
        if(file_exists($controllerName)){
            $this->info("ERROR--file exists!");
        }
        else{


        }

    }
}
