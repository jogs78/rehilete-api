<?php

namespace App\Http\Controllers;

use App\Models\Abono;
use App\Models\Evento;
use App\Models\Paquete;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbonoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $evRealizados = Evento::where('confirmacion', 'confirmado')->where('realizado', false)->get();
        //return $evRealizados->toJson();
        $paquetes = Paquete::pluck('id','nombre');
        $servicios = Servicio::pluck('id','nombre');
        $datosPivot = DB::table('evento_servicio')->get();
        $abonos = Abono::all();
        
        return response()->json([
            'servicios'=> $servicios->toJson(),
            'evRealizados'=> $evRealizados->toJson(),
            'datosextras'=> $datosPivot->toJson(),
            'paquetes'=> $paquetes->toJson(),
            'abonos'=> $abonos->toJson(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $abono = new Abono();
        $abono->evento_id = $request->evento_id;
        $abono->usuario_id = $request->usuario_id;
        $abono->descripcion = $request->descripcion;
        $abono->cantidad = $request->cantidad;
        $abono->save();

        return response()->json(["success"=> "No hay errores"],200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $abono = Abono::find($id);
        return $abono->toJson();
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $abono = Abono::find($id);
        $abono->evento_id = $request->evento_id;
        $abono->usuario_id = $request->usuario_id;
        $abono->descripcion = $request->descripcion;
        $abono->cantidad = $request->cantidad;
        $abono->save();

        return $abono->toJson();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $abono = Abono::find($id);
        if ($abono) {
            $abono->delete();
            return response()->json(["success"=> "abono eliminado correctamente"],200);
        }else
        {
            return response()->json(["errors"=> "No se pudo eliminar el abono"],400);
        }
    }
}
