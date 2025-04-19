<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAbonoRequest;
use App\Models\Abono;
use App\Models\Evento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class EventoAbonoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Evento $evento)
    {
        $user = Auth::getUser();
        Log::channel('debug')->info("Dentro del controller viewAny\n\tuser:".$user->toJson().", \n\tevento:".$evento->toJson());

        if (Gate::allows('viewAny', [Abono::class, $evento])) {
            if ($evento->estado == 'validado') {
                $abonos = $evento->abonos;
                if (count($abonos) == 0) {
                    return response()->json('sin abonos registrados');
                } else {
                    return response()->json($abonos);
                }
            } else {
                return response()->json('El evento no esta validado', 422);
            }
        } else {
            return response()->json('El usuario actual no puede ver los abonos de este evento', 403);

        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Evento $evento, Abono $abono)
    {
        if (Gate::allows('view', $abono)) {
            $pdf = Pdf::loadView('pdfs.recibo',compact('abono'));
            // Devuelve el PDF para descargar
            return $pdf->download('mi_documento.pdf');
            //return view('pdfs.recibo');    
        }else {
            return response()->json('El usuario actual no puede ver los abonos de este evento', 403);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAbonoRequest $request, Evento $evento)
    {
        if (Gate::allows('create', Abono::class)) {
            if ($evento->estado == 'validado') {
                $total = $evento->totalAbonos();
                $falta = $evento->precio - $total;

                Log::channel('debug')->info('Ha abonado:'.$total);

                //determinar si el ya  esta pagado o si hay que dar cambio
                if ($evento->precio == $total) {
                    return response()->json('El importe del evento ya ha sido cubierto con anterioridad', 422);
                }
                $usuario = Auth::getUser();
                $abono = new Abono;
                $abono->evento_id = $evento->id;
                $abono->quien_recibio = $usuario->id;
                $abono->descripcion = $request->descripcion;

                Log::channel('debug')->info('entrega:'.$total);
                Log::channel('debug')->info('aportaria:'.($total + $request->cantidad));
                Log::channel('debug')->info('precio:'.$evento->precio);

                if ($request->cantidad > $falta) {
                    $abono->cantidad = $falta;
                } else {
                    $abono->cantidad = $request->cantidad;
                }

                Log::channel('debug')->info('Listo para salvar la cantidad:'.$abono->cantidad);

                $abono->save();
                Log::channel('debug')->info('Guardo la cantidad:'.$abono->cantidad);

                if (($total + $request->cantidad) > $evento->precio) {
                    $abono->cambio = ($total + $request->cantidad) - $evento->precio;
                } else {
                    $abono->falta = $evento->precio - ($total + $request->cantidad);
                }
                $abono->precio_evento = $evento->precio;
                $abono->abonado = $evento->totalAbonos();

                //                $evento->load('abonos');
                return response()->json($abono);

            } else {
                return response()->json('El evento no esta validado', 422);
            }
        } else {
            return response()->json('El usuario actual no puede recibir abonos de este evento', 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evento $evento, Abono $abono)
    {
        if (Gate::allows('delete', $abono)) {
            if ($evento->estado == 'validado') {
                $abono->delete();

                return response()->json($abono);
            } else {
                return response()->json('El evento no esta validado', 422);
            }
        } else {
            return response()->json('El usuario actual no puede eliminar el abono de este evento', 403);
        }
    }
}
