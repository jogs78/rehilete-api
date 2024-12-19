<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaqueteRequest;
use App\Models\Paquete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class PaqueteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $usuario = auth()->User();

        if (is_null($usuario)) {
            Log::channel('debug')->info("usuario nulo");

            $paquetes = Paquete::where('activo', true)->get();

            return response()->json($paquetes);
        }
        
        switch ($usuario->rol) {
            case 'Gerente':
                $paquetes = Paquete::all();
                break;
            case 'Cliente':
            case 'Empleado':
                $paquetes = Paquete::where('activo', true)->get(); //
                break;
        }

        return response()->json($paquetes);
    }

    public function store(StorePaqueteRequest $request)
    {
        if (Gate::allows('create', Paquete::class)) {
            $paquete = new Paquete;
            $datos = $request->all();
            $datos['activo'] = false;
            //            if(isset($datos['activo']))unset($datos['activo']);
            $paquete->fill($datos);
            $paquete->load('imagenes', 'servicios');
            $paquete->save();
            if (isset($datos['select'])) {
                $servicios = $request->select;
                $cantidades = $request->cantidad_serv;
                foreach ($servicios as $servicio) {
                    // Verificar si existe la cantidad asociada a este servicio
                    if (array_key_exists($servicio, $cantidades) && $cantidades[$servicio] > 0) {
                        $paquete->servicios()->attach($servicio, ['servicio_cantidad' => $cantidades[$servicio]]);
                    } else {
                        // Si no hay cantidad asociada o es cero, no agregar el servicio
                        if (! array_key_exists($servicio, $cantidades) || $cantidades[$servicio] != 0) {
                            $paquete->servicios()->attach($servicio);
                        }
                    }
                }
            }

            return response()->json($paquete);
        } else {
            return response()->json('Solo el gerente puede crear paquetes', 403);
        }

        return response()->json($paquete);
    }

    /**
     * Display the specified resource.
     */
    public function show(Paquete $paquete)
    {
        //with('publicas','privadas')->
        $paquete->load('imagenes', 'servicios');

        return response()->json($paquete);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paquete $paquete)
    {
        if (Gate::allows('update', $paquete)) {
            $datos = $request->all();
            $paquete->fill($datos);
            $paquete->load('imagenes', 'servicios');
            $paquete->save();
            $servicios = $request->select;
            $paquete->servicios()->attach($servicios);

            return response()->json($paquete);
        } else {
            return response()->json('Solo el gerente puede actualizar paquetes o este paquete tiene eventos confirmado y pendiente', 403);
        }

        return response()->json($paquete);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paquete $paquete)
    {
        if (Gate::allows('delete', $paquete)) {
            // Obtener los IDs de los servicios asociados al paquete
            $serviciosIds = $paquete->servicios->pluck('id')->toArray();

            // Utiliza detach para eliminar las relaciones en la tabla pivote
            $paquete->servicios()->detach($serviciosIds);

            // Procede con la eliminación del paquete
            $paquete->delete();

            return response()->json($paquete);
        } else {
            return response()->json('Solo el gerente puede eliminar paquetes o o este paquete tiene eventos confirmado y pendiente', 403);
        }

        return response()->json($paquete);
    }

    
    public function activar(Paquete $paquete)
    {
        if(is_null($paquete->precio)) return response()->json("El precio no puede ser nulo",422);
        $paquete->activo = true;
        $paquete->save();

        return response()->json($paquete);
    }

    public function desactivar(Paquete $paquete)
    {
        if(is_null($paquete->activo)) return response()->json($paquete,422);
        $paquete->activo =false;
        $paquete->save();

        return response()->json($paquete);
    }
}
