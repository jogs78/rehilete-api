<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class ReEvento extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Borra todos los registros de la tabla eventos
        DB::table('eventos')->delete();

        // Ejecuta el seeder EventoSeeder
        $this->call(EventoSeeder::class);
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
