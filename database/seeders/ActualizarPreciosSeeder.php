<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ActualizarPreciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("
        UPDATE paquete_servicio ps
        JOIN servicios s ON ps.servicio_id = s.id
        SET ps.servicio_precio = s.precio
        ");
    }
}
