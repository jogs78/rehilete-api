<?php

namespace Database\Seeders;

use App\Models\Servicio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $serv = new Servicio;
        $serv->nombre = "Mantelería";
        $serv->precio = 100;
        $serv->descripcion = "Manteleria para las mesas";
        $serv->minimo = 0;
        $serv->save();

        $serv = new Servicio;
        $serv->nombre = "Meseros";
        $serv->precio = 200;
        $serv->descripcion = "Recomendado: 3 por mesa minimo";
        $serv->minimo = 0;
        $serv->save();
        
        $serv = new Servicio;
        $serv->nombre = "Aire acondicionado";
        $serv->precio = 800;
        $serv->descripcion = "Aire acondicionado para el  lugar";
        $serv->minimo = 1;
        $serv->save();

        $serv = new Servicio;
        $serv->nombre = "Cocina equipada";
        $serv->precio = 300;
        $serv->descripcion = "cocina con todo equipado.";
        $serv->minimo = 1;
        $serv->save();

        $serv = new Servicio;
        $serv->nombre = "Suministros para baños";
        $serv->precio =  100;
        $serv->descripcion = "papeles de baño, jabon, entre mas.";
        $serv->minimo = 1;
        $serv->save();

        $serv = new Servicio;
        $serv->nombre = "Tiempo del Salon";
        $serv->precio =  1000;
        $serv->descripcion = "5 horas";
        $serv->minimo = 1;
        $serv->save();

        $serv = new Servicio;
        $serv->nombre = "Mesa para pastel";
        $serv->precio =  150;
        $serv->descripcion = "Mesa grande";
        $serv->minimo = 0;
        $serv->save();

        $serv = new Servicio;
        $serv->nombre = "Mesa para recuerdo";
        $serv->precio =  100;
        $serv->descripcion = "Mesa mediana";
        $serv->minimo = 0;
        $serv->save();

        $serv = new Servicio;
        $serv->nombre = "Area Infantil";
        $serv->precio =  280;
        $serv->descripcion = "Area de juegos infantil";
        $serv->minimo = 1;
        $serv->save();

        $serv = new Servicio;
        $serv->nombre = "Mobiliario Infantil";
        $serv->precio =  200;
        $serv->descripcion = "Para 30 niños";
        $serv->minimo = 0;
        $serv->save();

        $serv = new Servicio;
        $serv->nombre = "Mobiliario";
        $serv->precio =  500;
        $serv->descripcion = "10 adultos y una mesa";
        $serv->minimo = 0;
        $serv->save();
    }
}
