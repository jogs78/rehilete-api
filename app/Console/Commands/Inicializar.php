<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
class Inicializar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inicializar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inicializar la base de datos (db:wipe, migrate --seed)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('db:wipe');
        Artisan::call('migrate', 
        [
           '--seed' => true,
           '--force' => true
        ]);        
    }
}
