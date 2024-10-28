<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Gasto;
use Illuminate\Http\Request;
use App\Http\Requests\StoreGastoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;

class EventoGastoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Evento $evento)
    {
        $user = Auth::getUser();
        Log::channel('debug')->info("Dentro del controller viewAny\n\tuser:" . $user->toJson() . ", \n\tevento:" . $evento->toJson());

        if (Gate::allows('viewAny', [Gasto::class, $evento])) {
            if( $evento->confirmacion == 'confirmado'){
                return response()->json($evento->gastos);
            }else{
                return response()->json("El evento no esta confirmado",422);
            }
        }else{
            return response()->json("El usuario actual no puede ver los gastos de este evento",403);

        }

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGastoRequest $request, Evento $evento)
    {
        if (Gate::allows('create', Gasto::class)) {
            if( $evento->confirmacion == 'confirmado'){
                $gasto = new gasto();
                $gasto->evento_id = $evento->id;
                $gasto->descripcion = $request->descripcion;
                $gasto->cantidad =  $request->cantidad;
                $gasto->save();
                Log::channel('debug')->info("Guardo la cantidad:" . $gasto->cantidad);
                return response()->json($gasto);
        
            }else{
                return response()->json("El evento no esta confirmado",422);
            }
        }else{
            return response()->json("El usuario actual no puede asentar gastos de este evento",403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evento $evento, Gasto $gasto)
    {
        if (Gate::allows('delete', [$gasto, $evento])) {
            if( $evento->confirmacion == 'confirmado'){
                $gasto->delete();
                return response()->json($gasto);            
            }else{
                return response()->json("El evento no esta confirmado",422);
            }
        }else{
            return response()->json("El usuario actual no puede eliminar el gasto de este evento",403);
        }
    }
}
