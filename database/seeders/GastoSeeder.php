<?php

namespace Database\Seeders;

use App\Models\Gasto;
use Illuminate\Database\Seeder;

class GastoSeeder extends Seeder
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
        $gasto = new Gasto;
        $gasto->evento_id = 2;
        $gasto->descripcion = 'Moviliario';
        $gasto->cantidad = 500;
        $gasto->save();

        $gasto = new Gasto;
        $gasto->evento_id = 2;
        $gasto->descripcion = 'Manteleria';
        $gasto->cantidad = 500;
        $gasto->save();

        $gasto = new Gasto;
        $gasto->evento_id = 6;
        $gasto->descripcion = 'Moviliario';
        $gasto->cantidad = 500;
        $gasto->save();

        $gasto = new Gasto;
        $gasto->evento_id = 6;
        $gasto->descripcion = 'Manteleria';
        $gasto->cantidad = 500;
        $gasto->save();

    }
}
