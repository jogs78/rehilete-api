<?php

namespace Database\Seeders;

use App\Models\Servicio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('servicios')->truncate();

        $servicio = new Servicio;
        $servicio->nombre = 'Mantelería';
        $servicio->precio = 100;
        $servicio->descripcion = 'Manteleria para las mesas';
        $servicio->minimo = 0;
        $servicio->maximo = 10;
        $servicio->cuantos = 10;
        $servicio->save();

        $servicio = new Servicio;
        $servicio->nombre = 'Meseros';
        $servicio->precio = 200;
        $servicio->descripcion = 'Recomendado: 1 por 2 mesas minimo';
        $servicio->minimo = 0;
        $servicio->cuantos = 10;
        $servicio->save();

        $servicio = new Servicio;
        $servicio->nombre = 'Aire acondicionado';
        $servicio->precio = 800;
        $servicio->descripcion = 'Aire acondicionado para el  lugar';
        $servicio->unico = true;
        $servicio->save();

        $servicio = new Servicio;
        $servicio->nombre = 'Cocina equipada';
        $servicio->precio = 300;
        $servicio->descripcion = 'cocina con todo equipado.';
        $servicio->unico = true;
        $servicio->save();

        $servicio = new Servicio;
        $servicio->nombre = 'Suministros para baños';
        $servicio->precio = 100;
        $servicio->descripcion = 'papeles de baño, jabon, entre mas.';
        $servicio->unico = true;
        $servicio->save();

        $servicio = new Servicio;
        $servicio->nombre = 'Tiempo del Salon';
        $servicio->precio = 1000;
        $servicio->descripcion = '5 horas';
        $servicio->unico = true;
        $servicio->save();

        $servicio = new Servicio;
        $servicio->nombre = 'Mesa para pastel';
        $servicio->precio = 150;
        $servicio->descripcion = 'Mesa grande';
        $servicio->unico = true;
        $servicio->save();

        $servicio = new Servicio;
        $servicio->nombre = 'Mesa para regalos';
        $servicio->precio = 100;
        $servicio->descripcion = 'Mesa mediana';
        $servicio->minimo = 0;
        $servicio->maximo = 2;
        $servicio->save();

        $servicio = new Servicio;
        $servicio->nombre = 'Area Infantil';
        $servicio->precio = 280;
        $servicio->descripcion = 'Area de juegos infantil';
        $servicio->unico = true;
        $servicio->save();

        $servicio = new Servicio;
        $servicio->nombre = 'Mobiliario Infantil';
        $servicio->precio = 200;
        $servicio->descripcion = 'Para 10 niños';
        $servicio->minimo = 0;
        $servicio->maximo = 3;
        $servicio->cuantos = 10;
        $servicio->save();

        $servicio = new Servicio;
        $servicio->nombre = 'Mobiliario';
        $servicio->precio = 500;
        $servicio->descripcion = '10 adultos y una mesa';
        $servicio->minimo = 0;
        $servicio->minimo = 10;
        $servicio->cuantos = 10;
        $servicio->save();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
