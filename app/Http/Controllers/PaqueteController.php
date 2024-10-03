<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaqueteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuario = auth()->User();
        if(is_null($usuario)){
            $paquetes = Paquete::with('servicios','imagenes')->where('activo',true)->get();
            return response()->json($paquetes);
        }
        switch ($usuario->rol) {
            case 'Gerente':
                $paquetes = Paquete::with('servicios','imagenes')->all();
                break;
            case 'Cliente':
                $paquetes = Paquete::with('servicios','imagenes')->where('activo',true)->get();
                break;
            
            default:
                # code...
                break;
        }
        return response()->json($paquetes);
    }

    /**
     * Store a newly created resource in storage.\
     * @return [vista] [en la que se muestra]
     */
    public function store(Request $request)
    {
        $this->authorize('create', Paquete::class);
        $paquete = new Paquete();
        $paquete->nombre = $request->nombre;
        $paquete->activo = $request->activo;
        $paquete->precio = $request->precio;
        $paquete->descripcion = $request->descripcion;
        $paquete->save();

        $paquete = Paquete::find($paquete->id);
        $servSelect = $request->select;

        $cantidades = $request->cantidad_serv;

        
        foreach ($servSelect as $servi) {
            // Verificar si existe la cantidad asociada a este servicio
            if (array_key_exists($servi, $cantidades) && $cantidades[$servi] > 0) {
                $paquete->servicios()->attach($servi, ['servicio_cantidad' => $cantidades[$servi]]);
            } else {
                // Si no hay cantidad asociada o es cero, no agregar el servicio
                if (!array_key_exists($servi, $cantidades) || $cantidades[$servi] != 0) {
                    $paquete->servicios()->attach($servi);
                }
            }
        }
        
        /*foreach ($servSelect as $servi) {
            // Verificar si existe la cantidad asociada a este servicio
            if (array_key_exists($servi, $cantidades) && $cantidades[$servi] > 0) {
                $paquete->servicios()->attach($servi, ['servicio_cantidad' => $cantidades[$servi]]);
            } else {
                // Si no hay cantidad asociada, simplemente agregar el servicio al paquete
                $paquete->servicios()->attach($servi);
            }
        }*/

        //$paquete -> servicios() -> attach($servSelect);
        
        return response()->json(["success"=> "No hay errores"],200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //with('publicas','privadas')->
        $paquete = Paquete::find($id);
        $datosPaq = DB::table('paquete_servicio')->get();

        // Obtener los servicios relacionados con este paquete específico.
        $servicios = $paquete->servicios;
        return [
            'paquete' => $paquete->toJson(),
            'paq_serv' => $datosPaq->toJson(),
            'servicios' => $servicios->toJson(),
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $paquete = Paquete::find($id);
        return view('', compact('paquete'));    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update', Paquete::find($id));
        $paquete = Paquete::find($id);
        $paquete->nombre = $request->nombre;
        $paquete->activo = $request->activo;
        $paquete->precio = $request->precio;
        $paquete->descripcion = $request->descripcion;
        $paquete->save(); 
        $paquete = Paquete::find($paquete->id);
        $servSelect = $request->select;
        $paquete -> servicios() -> attach($servSelect);
        return $paquete->toJson();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', Paquete::find($id));
        $paquete = Paquete::find($id);
        if ($paquete) {
            // Obtener los IDs de los servicios asociados al paquete
            $serviciosIds = $paquete->servicios->pluck('id')->toArray();

            // Utiliza detach para eliminar las relaciones en la tabla pivote
            $paquete->servicios()->detach($serviciosIds);

            // Procede con la eliminación del paquete
            $paquete->delete();
            return response()->json(["success"=> "Paquete eliminado correctamente"],200);
        }else
        {
            return response()->json(["errors"=> "No se pudo eliminar el Paquete"],400);
        }
    }
}
