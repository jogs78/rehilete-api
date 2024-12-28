<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PaqueteServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Paquete $paquete)
    {
        return response()->json($paquete->servicios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Paquete $paquete)
    {

        $validator = Validator::make($request->all(), [
            'servicio' => 'required|integer',//|array
            'cantidad' => [
                'nullable',
                'integer',
//                'array',
                Rule::requiredIf(function () use ($request) {
                    return ! empty($request->servicio)
                    && ! empty($request->cantidad);
//                    && count($request->servicios) !==
//                    count($request->cantidades);
                }),
            ],
        ], [
            'servicio.required' => 'El campo :attribute es obligatorio.',
            'cantidad.required' => 'Los arreglos servicios y cantidades deben tener el mismo tamaño.',
            'servicio.array' => 'El campo :attribute debe ser un arreglo.',
            'cantidad.array' => 'El campo :attribute debe ser un arreglo.',
            'servicio.integer' => 'El campo :attribute debe ser un entero.',
            'cantidad.integer' => 'El campo :attribute debe ser un entero.',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $cantidad = $request->cantidad;
        if(is_null($request->cantidad))$cantidad=0;

        $paquete->servicios()->attach( $request->servicio, ['servicio_cantidad' =>$cantidad ]);

        /*
        $servicios = $request->servicios;

        foreach ($servicios as $servicio) {
            // Verificar si existe la cantidad asociada a este servicio
            if (array_key_exists($servicio, $cantidades) && $cantidades[$servicio] > 0) {
                $paquete->servicios()->attach($servicio, ['servicio_cantidad' => $cantidades[$servicio]]);
            } else {
                //jogs modificar que no sea cantidades[#misma_key]
                // Si no hay cantidad asociada o es cero, no agregar el servicio
                if (! array_key_exists($servicio, $cantidades) || $cantidades[$servicio] != 0) {
                    $paquete->servicios()->attach($servicio);
                }
            }
        }
        return response()->json($paquete->servicios);

    */
        $ultimoServicio = $paquete->servicios()->latest('paquete_servicio.created_at','desc')->first();
        return response()->json($ultimoServicio);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paquete $paquete, Servicio $servicio)
    {
        $paquete->servicios()->detach($servicio->id);

        return response()->json($servicio);
    }
}
