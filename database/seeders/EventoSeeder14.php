<?php

namespace Database\Seeders;

use App\Models\Evento;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EventoSeeder14 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $evento = Evento::find(14);
        if ($evento) $evento->delete();
        
        $evento = new Evento;
        $evento->id = 14;
        $evento->motivo = 'Evento hace 1h, Hugo';
        $evento->usuario_id = 1;
        $evento->paquete_id = 4;
        $evento->precio = 8000;
        $evento->fecha = Carbon::today()->format("Y-m-d");
        $evento->hora_inicio = Carbon::now()->subHours(1)->format("H:00:00");
        $evento->hora_fin = Carbon::now()->format("H:00:00");;
        $evento->descripcion = 'Pruebas con fotos';
        $evento->num_personas = 80;
        $evento->confirmacion = 'validado';
        $evento->realizado = false;
        $evento->save();
        $evento->servicios()->attach([1, 2, 3]);

    }
}
