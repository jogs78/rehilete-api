<?php

namespace Database\Seeders;

use App\Models\Abono;
use Illuminate\Database\Seeder;

class AbonoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
                los eventos confirmados son
                2 -> 15000
                6 -> 10000
                7 -> 15000
                9 -> 8000
                13-> 8000

                carlos es 4
                empleado es 5
        */
        $abono = new Abono;
        $abono->evento_id = 2;
        $abono->quien_recibio = 4;
        $abono->descripcion = 'Apartado del evento';
        $abono->cantidad = 500;
        $abono->save();

        $abono = new Abono;
        $abono->evento_id = 2;
        $abono->quien_recibio = 5;
        $abono->descripcion = 'Adelanto del evento';
        $abono->cantidad = 4500;
        $abono->save();

        $abono = new Abono;
        $abono->evento_id = 2;
        $abono->quien_recibio = 4;
        $abono->descripcion = 'Resto del evento';
        $abono->cantidad = 10000;
        $abono->save();

        $abono = new Abono;
        $abono->evento_id = 6;
        $abono->quien_recibio = 4;
        $abono->descripcion = 'Apartado del evento';
        $abono->cantidad = 500;
        $abono->save();

        $abono = new Abono;
        $abono->evento_id = 6;
        $abono->quien_recibio = 5;
        $abono->descripcion = 'Liquidar el evento';
        $abono->cantidad = 9500;
        $abono->save();

        $abono = new Abono;
        $abono->evento_id = 7;
        $abono->quien_recibio = 4;
        $abono->descripcion = 'Pago del evento';
        $abono->cantidad = 15000;
        $abono->save();

        $abono = new Abono;
        $abono->evento_id = 9;
        $abono->quien_recibio = 4;
        $abono->descripcion = 'Pago del evento';
        $abono->cantidad = 7500; //solo falta 500
        $abono->save();

    }
}
