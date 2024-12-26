<?php

namespace Database\Seeders;

use App\Models\Paquete;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaqueteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('paquetes')->truncate();


        $paquete = new Paquete;
        $paquete->nombre = 'Bodas';
        $paquete->precio = 6600;
        $paquete->activo = true;
        $paquete->descripcion = '¡Felicidades por su compromiso! ¿Está buscando el lugar perfecto para celebrar su boda? Nuestro salón para bodas es el lugar ideal para que usted y sus invitados creen recuerdos inolvidables.';
        $paquete->save();
        $paquete->servicios()->attach([
            1 => ['servicio_cantidad' => 12],
            2 => ['servicio_cantidad' => 9],
            3 => ['servicio_cantidad' => null],
            4 => ['servicio_cantidad' => null],
            5 => ['servicio_cantidad' => null],
            6 => ['servicio_cantidad' => null],
            7 => ['servicio_cantidad' => 1],
            8 => ['servicio_cantidad' => 1],
            9 => ['servicio_cantidad' => null],
            10 => ['servicio_cantidad' => 1],
            11 => ['servicio_cantidad' => 10],
        ]);

        $paquete = new Paquete;
        $paquete->nombre = 'XV Años';
        $paquete->precio = 6000;
        $paquete->activo = true;
        $paquete->descripcion = '¡Celebre su gran día con estilo en nuestro salón para XV años! Nuestro salón es el lugar ideal para una fiesta inolvidable que marque el comienzo de una nueva etapa en la vida. Con un ambiente sofisticado y elegante, nuestro salón es perfecto para albergar una gran celebración rodeada de amigos y familiares.';
        $paquete->save();
        $paquete->servicios()->attach([
            1 => ['servicio_cantidad' => 10],
            2 => ['servicio_cantidad' => 9],
            3 => ['servicio_cantidad' => null],
            4 => ['servicio_cantidad' => null],
            5 => ['servicio_cantidad' => null],
            6 => ['servicio_cantidad' => null],
            7 => ['servicio_cantidad' => 1],
            8 => ['servicio_cantidad' => 1],
            9 => ['servicio_cantidad' => null],

        ]);

        $paquete = new Paquete;
        $paquete->nombre = 'Fiesta infantil';
        $paquete->precio = 6000;
        $paquete->activo = true;
        $paquete->descripcion = '¡Haga que el cumpleaños de su hijo sea mágico en nuestro salón para fiestas infantiles! Nuestro salón está diseñado para proporcionar un ambiente seguro y divertido para que los niños disfruten de su gran día rodeados de amigos y familiares.';
        $paquete->save();
        $paquete->servicios()->attach([
            1 => ['servicio_cantidad' => 7],
            2 => ['servicio_cantidad' => 6],
            3 => ['servicio_cantidad' => null],
            4 => ['servicio_cantidad' => null],
            5 => ['servicio_cantidad' => null],
            6 => ['servicio_cantidad' => null],
        ]);

        $paquete = new Paquete;
        $paquete->nombre = 'Bautizos';
        $paquete->precio = 4500;
        $paquete->activo = false;
        $paquete->descripcion = '¡Celebre un día especial en nuestro salón para bautizos! Nuestro salón es el lugar ideal para un evento íntimo y acogedor para celebrar la bendición del bautizo de su hijo o hija. Ofrecemos una atmósfera tranquila y relajada para que usted y sus invitados disfruten del momento y creen recuerdos inolvidables.';
        $paquete->save();
        $paquete->servicios()->attach([
            1 => ['servicio_cantidad' => 7],
            3 => ['servicio_cantidad' => null],
            4 => ['servicio_cantidad' => null],
        ]);

        $paquete = new Paquete;
        $paquete->nombre = 'Paquete infantil básico';
        $paquete->precio = 2800.00;
        $paquete->activo = true;
        $paquete->descripcion = 'Incluye:
        *Salon
        *Mobiliario infantil para 30 niños
        *Sillas para 50 adultos
        *Mesa para pastel
        *Mesa para recuerdos
        * Carrito de servicio
        *Cocina equipada 
        *Sonido ambiental
        *Suministros para baños
        *Área de juegos infantiles
        *Servicio de 5hrs.
        ';
        $paquete->save();
        $paquete->servicios()->attach([
            2 => ['servicio_cantidad' => 9],
            4 => ['servicio_cantidad' => null],
            5 => ['servicio_cantidad' => null],
            6 => ['servicio_cantidad' => null],
            7 => ['servicio_cantidad' => 1],
            8 => ['servicio_cantidad' => 1],
            9 => ['servicio_cantidad' => null],
            10 => ['servicio_cantidad' => 1],
            11 => ['servicio_cantidad' => 5],
        ]);

        $paquete = new Paquete;
        $paquete->nombre = 'Paquete fiesta';
        $paquete->precio = 3300.00;
        $paquete->activo = true;
        $paquete->descripcion = 'Incluye:
        *Salon 
        *Mobiliario infantil para 30 niños
        *Mobiliario para 50 adultos (mesa redonda o rectangular, silla acojinada, mantelería básica)
        *Mesa para pastel/ dulces
        *Mesa para regalo
        *Cocina equipada
        *Sonido ambiental.
        *Insumos higiénicos
        * Área infantil
        * Servicio por 5 hrs.
        ';
        $paquete->save();
        $paquete->servicios()->attach([
            2 => ['servicio_cantidad' => 6],
            4 => ['servicio_cantidad' => null],
            5 => ['servicio_cantidad' => null],
            6 => ['servicio_cantidad' => null],
            7 => ['servicio_cantidad' => 1],
            8 => ['servicio_cantidad' => 1],
            9 => ['servicio_cantidad' => null],
            10 => ['servicio_cantidad' => 1],
            11 => ['servicio_cantidad' => 5],
        ]);

        $paquete = new Paquete;
        $paquete->nombre = 'Paquete Baby Shower';
        $paquete->precio = 3300.00;
        $paquete->activo = true;
        $paquete->descripcion = 'Incluye:
        *Mobiliario para 40 adultos (mesa redonda o rectangular, silla acojinada, mantelería básica)
        *Mesa para pastel/ dulces
        *Mesa para regalos
        *Carrito de servicio. 
        *Cocina equipada. 
        *Sonido ambiental.
        *Insumos  higienicos
        *Servicio por 5 hrs. ';
        $paquete->save();
        $paquete->servicios()->attach([
            2 => ['servicio_cantidad' => 3],
            4 => ['servicio_cantidad' => null],
            5 => ['servicio_cantidad' => null],
            6 => ['servicio_cantidad' => null],
            7 => ['servicio_cantidad' => 1],
            8 => ['servicio_cantidad' => 1],
            9 => ['servicio_cantidad' => null],
            10 => ['servicio_cantidad' => 1],
            11 => ['servicio_cantidad' => 4],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
