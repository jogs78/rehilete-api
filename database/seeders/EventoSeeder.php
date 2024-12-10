<?php

namespace Database\Seeders;

use App\Models\Evento;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $evento = new Evento;
        $evento->id = 1;
        $evento->motivo = 'Evento AE1, Hugo';
        $evento->usuario_id = 1;
        $evento->paquete_id = 3;
        $evento->precio = 10000;
        $evento->fecha = '2024-01-27';
        $evento->hora_inicio = '09:00';
        $evento->hora_fin = '14:30';
        $evento->descripcion = 'Celebrare el cumpleaños de mi hijo, dice Hugo';
        $evento->num_personas = 150;
        $evento->confirmacion = 'sin confirmar';
        $evento->save();
        $evento->servicios()->attach([2, 3]);

        $evento = new Evento;
        $evento->id = 2;
        $evento->motivo = 'Evento AE2, Paco';
        $evento->usuario_id = 2;
        $evento->paquete_id = 2;
        $evento->precio = 15000;
        $evento->fecha = '2024-02-27';
        $evento->hora_inicio = '10:00';
        $evento->hora_fin = '06:30';
        $evento->descripcion = 'Celebraremos los quince años de mi prima, paco';
        $evento->num_personas = 300;
        $evento->confirmacion = 'confirmado';
        $evento->gerente_id = 4;
        $evento->realizado = true;
        $evento->save();
        $evento->servicios()->attach([1, 3]);

        $evento = new Evento;
        $evento->id = 3;
        $evento->motivo = 'Evento AE3, Paco';
        $evento->usuario_id = 2;
        $evento->paquete_id = 3;
        $evento->precio = 5000;
        $evento->fecha = '2024-03-27';
        $evento->hora_inicio = '11:00';
        $evento->hora_fin = '17:00';
        $evento->descripcion = 'Celebraremos el cumpleaños numero 10 de mi hijo, paco';
        $evento->num_personas = 50;
        $evento->confirmacion = 'sin confirmar';
        $evento->save();
        $evento->servicios()->attach([2]);

        $evento = new Evento;
        $evento->id = 4;
        $evento->motivo = 'Evento AE4, Paco';
        $evento->usuario_id = 2;
        $evento->paquete_id = 4;
        $evento->precio = 8000;
        $evento->fecha = '2024-04-27';
        $evento->hora_inicio = '12:00';
        $evento->hora_fin = '17:30';
        $evento->descripcion = 'Bautizaremos a mi sobrinito';
        $evento->num_personas = 80;
        $evento->confirmacion = 'rechazado';
        $evento->razon = 'Esa fecha ya esta ocupada';
        $evento->save();
        $evento->servicios()->attach([3]);

        $evento = new Evento;
        $evento->id = 5;
        $evento->motivo = 'Evento AE5, Luis';
        $evento->usuario_id = 3;
        $evento->paquete_id = 2;
        $evento->precio = 12000;
        $evento->fecha = '2024-05-27';
        $evento->hora_inicio = '13:00';
        $evento->hora_fin = '03:30';
        $evento->descripcion = 'Mi hija llega a sus xv años y lo haremos en grande';
        $evento->num_personas = 250;
        $evento->confirmacion = 'sin confirmar';
        $evento->save();
        $evento->servicios()->attach([1, 2, 3]);

        $evento = new Evento;
        $evento->id = 6;
        $evento->motivo = 'Evento AE6, Hugo';
        $evento->usuario_id = 1;
        $evento->paquete_id = 3;
        $evento->precio = 10000;
        $evento->fecha = '2024-06-27';
        $evento->hora_inicio = '12:00';
        $evento->hora_fin = '20:30';
        $evento->descripcion = 'Celebrare el cumpleaños numero 6 de mis hijos';
        $evento->num_personas = 50;
        $evento->confirmacion = 'confirmado';
        $evento->save();
        $evento->servicios()->attach([3]);

        $evento = new Evento;
        $evento->id = 7;
        $evento->motivo = 'Evento AE7, Paco';
        $evento->usuario_id = 2;
        $evento->paquete_id = 2;
        $evento->precio = 15000;
        $evento->fecha = '2024-07-27';
        $evento->hora_inicio = '10:00';
        $evento->hora_fin = '06:30';
        $evento->descripcion = 'Celebraremos los quince años de mi hermana';
        $evento->num_personas = 100;
        $evento->confirmacion = 'confirmado';
        $evento->save();
        $evento->servicios()->attach([1, 2]);

        $evento = new Evento;
        $evento->id = 8;
        $evento->motivo = 'Evento AE8, Paco';
        $evento->usuario_id = 2;
        $evento->paquete_id = 3;
        $evento->precio = 5000;
        $evento->fecha = '2024-08-27';
        $evento->hora_inicio = '11:00';
        $evento->hora_fin = '17:00';
        $evento->descripcion = 'Celebraremos el cumpleaños numero 10 de mi hijo';
        $evento->num_personas = 150;
        $evento->confirmacion = 'rechazado';
        $evento->save();
        $evento->servicios()->attach([1, 2, 3]);

        $evento = new Evento;
        $evento->id = 9;
        $evento->motivo = 'Evento AE9, Paco';
        $evento->usuario_id = 2;
        $evento->paquete_id = 4;
        $evento->precio = 8000;
        $evento->fecha = '2024-09-27';
        $evento->hora_inicio = '11:00';
        $evento->hora_fin = '17:30';
        $evento->descripcion = 'Bautizaremos a mi hijo';
        $evento->num_personas = 80;
        $evento->confirmacion = 'confirmado';
        $evento->realizado = true;
        $evento->gerente_id = 9;
        $evento->save();
        $evento->servicios()->attach([1, 2, 3]);

        $evento = new Evento;
        $evento->id = 10;
        $evento->motivo = 'Evento AE10, Luis';
        $evento->usuario_id = 3;
        $evento->paquete_id = 2;
        $evento->precio = 12000;
        $evento->fecha = '2024-05-27';
        $evento->hora_inicio = '20:00';
        $evento->hora_fin = '02:00';
        $evento->descripcion = 'Mi hija llega a sus xv años y lo haremos en grande';
        $evento->num_personas = 250;
        $evento->confirmacion = 'sin confirmar';
        $evento->save();
        $evento->servicios()->attach([1, 2, 3]);

        $evento = new Evento;
        $evento->id = 11;
        $evento->motivo = 'Evento AE10, Luis';
        $evento->usuario_id = 3;
        $evento->paquete_id = 2;
        $evento->precio = 12000;
        $evento->fecha = '2024-05-28';
        $evento->hora_inicio = '20:00';
        $evento->hora_fin = '03:30';
        $evento->descripcion = 'TornaXV';
        $evento->num_personas = 250;
        $evento->confirmacion = 'sin confirmar';
        $evento->save();
        $evento->servicios()->attach([1, 2, 3]);

        $evento = new Evento;
        $evento->id = 12;
        $evento->motivo = 'Evento AE12, Luis';
        $evento->usuario_id = 3;
        $evento->paquete_id = 2;
        $evento->precio = 12000;
        $evento->fecha = '2024-05-28';
        $evento->hora_inicio = '21:00';
        $evento->hora_fin = '03:30';
        $evento->descripcion = 'TornaXV';
        $evento->num_personas = 250;
        $evento->confirmacion = 'sin confirmar';
        $evento->save();

        $evento = new Evento;
        $evento->id = 13;
        $evento->motivo = 'Evento hoy, Paco';
        $evento->usuario_id = 2;
        $evento->paquete_id = 4;
        $evento->precio = 8000;
        $evento->fecha = Carbon::today()->format("Y-m-d");
        $evento->hora_inicio = '16:00';
        $evento->hora_fin = '23:59';
        $evento->descripcion = 'Pruebas con fotos';
        $evento->num_personas = 80;
        $evento->confirmacion = 'confirmado';
        $evento->realizado = true;
        $evento->save();
        $evento->servicios()->attach([1, 2, 3]);

    }
}
