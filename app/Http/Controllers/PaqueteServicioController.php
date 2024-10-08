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
            'servicios' => 'required|array',
            'cantidades' => [
                'required',
                'array',
                Rule::requiredIf(function () use ($request) {
                    return !empty($request->servicios) 
                    && !empty($request->cantidades) 
                    && count($request->servicios) !== 
                    count($request->cantidades);
                })
            ],
        ], [
            'servicios.required' => 'El campo :attribute es obligatorio.',
            'cantidades.required' => 'Los arreglos servicios y cantidades deben tener el mismo tamaño.',
            'servicios.array' => 'El campo :attribute debe ser un arreglo.',
            'cantidades.array' => 'El campo :attribute debe ser un arreglo.'
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }



        $servicios = $request->servicios;
        $cantidades = $request->cantidades;
        foreach ($servicios as $servicio) {
            // Verificar si existe la cantidad asociada a este servicio
            if (array_key_exists($servicio, $cantidades) && $cantidades[$servicio] > 0) {
                $paquete->servicios()->attach($servicio, ['servicio_cantidad' => $cantidades[$servicio]]);
            } else {
                //jogs modificar que no sea cantidades[#misma_key]
                // Si no hay cantidad asociada o es cero, no agregar el servicio
                if (!array_key_exists($servicio, $cantidades) || $cantidades[$servicio] != 0) {
                    $paquete->servicios()->attach($servicio);
                }
            }
        }
        return response()->json($paquete->servicios);        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paquete $paquete, Servicio $servicio)
    {
        $paquete->servicios()->detach($servicio->id);
        return response()->json($paquete->servicios);
    }
}
