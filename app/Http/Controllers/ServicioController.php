<?php

namespace App\Http\Controllers;

use App\Models\Servicio;

use Illuminate\Http\Request;
use App\Http\Requests\StoreServicioRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Log::channel('debug')->info('index de servicios.');
        $servicios = Servicio::with('imagenes')->get();
        return response()->json($servicios);

    }

    public function store(StoreServicioRequest $request)
    {
        if(Gate::allows('create' , Servicio::class  )){
            $servicio = new Servicio();
            $datos = $request->all();
            $servicio->fill($datos);
            $servicio->load('imagenes');
            $servicio->save();
            return response()->json($servicio);
        }else{
            return response()->json("Solo el gerente puede crear servicios",403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Servicio $servicio )
    {
        Log::channel('debug')->info('show de servicios.');

        $servicio->load('imagenes');
        return response()->json($servicio);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Servicio $servicio)
    {

        Log::channel('debug')->info('update1 de servicios.:' . json_encode($request->all()) );
        Log::channel('debug')->info('update1 de servicios.:' . $servicio->toJson() );

        if(Gate::allows('update' , $servicio)){
            $datos = $request->all();
            Log::channel('debug')->info('update de servicios.:' . json_encode($datos) );
            $servicio->fill($datos);
            $servicio->load('imagenes');
            $servicio->save();
            return response()->json($servicio);
        }else{
            return response()->json("Solo el gerente puede actualizar servicios",403);
        }            
        return response()->json($servicio);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Servicio $servicio)
    {
        if(Gate::allows('delete' , $servicio)){
            //determinar si puedo eliminarlo
            if($servicio->eventos()->count()>0) return response()->json("Este servicio es usado en algun evento",422);
            foreach($servicio->paquetes as $paquete)
                if($paquete->eventos()->count()>0) return response()->json("Este servicio es usado en en un paquete que esta usado en algun evento",422);

            $servicio->delete();
            return response()->json($servicio);
        }else{
            return response()->json("Solo el gerente puede eliminar servicios",403);
        }            
        return response()->json($servicio);
    }
}
