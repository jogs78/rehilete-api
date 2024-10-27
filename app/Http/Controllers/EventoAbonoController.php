<?php

namespace App\Http\Controllers;

use App\Models\Abono;
use App\Http\Requests\StoreAbonoRequest;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class EventoAbonoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Evento $evento)
    {
        if (Gate::allows('viewAny', [Abono::class, $evento])) {
            if( $evento->confirmacion == 'confirmado'){
                return response()->json($evento->abonos);
            }else{
                return response()->json("El evento no esta confirmado",422);
            }
        }else{
            return response()->json("El usuario actual no puede ver los abonos de este evento",403);

        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAbonoRequest $request, Evento $evento)
    {
        if (Gate::allows('create', Abono::class)) {
            if( $evento->confirmacion == 'confirmado'){
                $total= $evento->totalAbonos();
                //determinar si el ya  esta pagado o si hay que dar cambio
                if($evento->precio == $total ){
                    return response()->json("El importe del evento ya ha sido cubierto con anterioridad",422);
                }
                $usuario=Auth::getUser();
                $abono = new Abono();
                $abono->evento_id = $evento->id;
                $abono->quien_recibio = $usuario->id;
                $abono->descripcion = $request->descripcion;
                $abono->cantidad = $request->cantidad;
                $abono->save();
                if(($total + $request->cantidad) > $evento->precio)
                    $abono->cambio = ($total + $request->cantidad) - $evento->precio;
                else
                    $abono->falta =  $evento->precio - ($total + $request->cantidad) ;
                $abono->precio_evento = $evento->precio;
                $abono->abonado = $evento->totalAbonos();
//                $evento->load('abonos');
                return response()->json($abono);
        
            }else{
                return response()->json("El evento no esta confirmado",422);
            }
        }else{
            return response()->json("El usuario actual no puede recibir abonos de este evento",403);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evento $evento, Abono $abono)
    {
        if (Gate::allows('create', Abono::class)) {
            if( $evento->confirmacion == 'confirmado'){
                $abono->delete();
                return response()->json($abono);            
            }else{
                return response()->json("El evento no esta confirmado",422);
            }
        }else{
            return response()->json("El usuario actual no puede eliminar el abono de este evento",403);
        }
    }

}
