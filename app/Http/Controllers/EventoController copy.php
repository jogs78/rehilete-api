<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Paquete;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreEventoRequest;
use App\Http\Requests\RechazarEventoRequest;
use App\Http\Requests\ConfirmarEventoRequest;
use App\Http\Requests\UpdateEventoRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class EventoController extends Controller
{
    public function __construct()
    {
        // Llama al método de actualización de estados al construir la instancia del controlador
       // $this->actualizarEstadoEventos();
    }
    public function actualizarEstadoEventos()
    {
        // Obtén los eventos confirmados que cumplen con la condición
        $eventosPendientes = Evento::where('confirmacion', 'confirmado')
            ->where(function ($query) {
                $query->where('fecha', '<', now()->toDateString())
                      ->orWhere(function ($query) {
                          $query->where('fecha', '=', now()->toDateString())
                                ->where('hora_fin', '<', now()->toTimeString());
                      });
            })->get();

        // Actualiza el estado de los eventos
        foreach ($eventosPendientes as $evento) {
            $evento->update(['realizado' => true]);
        }

        // Puedes devolver una respuesta o redireccionar según tus necesidades
        return response()->json(['message' => 'Estado de eventos actualizado correctamente']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $usuario = Auth::getUser();
        switch ($usuario->rol) {
            case 'Gerente':
                $eventos = Evento::with('servicios', 'fotos')->get();
                break;
            case 'Cliente':
                $eventos = Evento::with('servicios', 'fotos')->where('usuario_id', $usuario->id)->get();
                break;
            case 'Empleado':
                $eventos = Evento::with('servicios', 'fotos')->where('confirmacion', 'confirmado')->get();
                break;
            default:
                # code...
                break;
        }
        return response()->json($eventos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventoRequest $request)
    {
        if(Gate::allows('create' , Evento::class )){  
            Log::channel('debug')->info("Confirmando");
            $usuario = Auth::getUser();
            $gerente = $usuario->rol == 'Gerente';
            $puso_fin = isset($request->hora_fin);
            $puso_precio = isset($request->precio);
            ob_start();
            var_dump($puso_fin);
            $salida = ob_get_clean();
            Log::channel('debug')->info('hora_inicio:' . $request->hora_inicio );

            $hora_inicial = Carbon::parse($request->hora_inicio);
            $hora_final = $hora_inicial;
            $gerente && $puso_fin ? $hora_final =  Carbon::parse($request->hora_fin) : $hora_final = Carbon::parse($request->hora_inicio)->addHours(6);
            
            $acumulado = Paquete::find($request->paquete_id)->precio;

            Log::channel('debug')->info('HORAS:' . $hora_inicial->format('H:i:s') );
            Log::channel('debug')->info('HORAS:' . $hora_final->format('H:i:s') );

            $evento = new Evento();
            $evento->nombre = $request->nombre;
            $evento->usuario_id = $gerente ? $request->usuario_id : $usuario->id;
            $evento->paquete_id = $request->paquete_id;
            $evento->paquete_precio = $acumulado;
//            $evento->precio = $acumulado;
            $evento->fecha = date($request-> fecha);
            $evento->hora_inicio = $hora_inicial->format('H:i:s');
            $evento->hora_fin = $hora_final->format('H:i:s');
            $evento->descripcion = $request->descripcion;
            if($gerente) $evento->gerente_id = $usuario->id ;
            $evento->num_personas = $request->num_personas; //en teoria deberia dar error si es mas de 100
  
            if(isset($request->servicios)){
                $servicios = $request -> servicios;
                ob_start();
                var_dump($servicios);
                $salida = ob_get_clean();
                Log::channel('debug')->info('salida:' . $salida);
                foreach ($servicios as $servicio) {
                    $servicio = Servicio::find($servicio);
                    $acumulado += $servicio->precio;
                    $evento -> servicios() -> attach($servicio,['servicio_precio'=> $servicio->precio]);
                }
            }

            $gerente && $puso_precio ? $evento->precio =  $request->precio : $evento->precio = $acumulado;
            $evento->save();
            $evento->load('servicios');
            return response()->json($evento);

        }else{
            return response()->json("Solo el gerente puede agregar eventos",403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $r, Evento  $evento)
    {
        if(Gate::allows('view', $evento )){
            $evento->load('servicios', 'fotos');
            return response()->json($evento);
        }else{
            return response()->json("El usuario actual no puede ver este evento",403);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventoRequest $request, Evento  $evento)
    {
        if(Gate::allows('update', $evento )){
            $usuario = Auth::getUser();
            $gerente = $usuario->rol == 'Gerente';
            $puso_fin = isset($request->hora_fin);
            $puso_precio = isset($request->precio);
            $datos=$request->all();

            if(isset($datos['nombre']))$evento->nombre = $datos['nombre'];
            if(isset($datos['usuario_id']))$evento->usuario_id = $datos['usuario_id'];
            if(isset($datos['paquete_id']))$evento->paquete_id = $datos['paquete_id'];
            if($gerente && isset($datos['precio']))$evento->precio = $datos['precio'];
            if(isset($datos['fecha']))$evento->fecha =date($datos['fecha']);
            if(isset($datos['hora_inicio']))$evento->hora_inicio = Carbon::parse($datos['hora_inicio'])->format('H:i:s');

           
            if($gerente && isset($datos['hora_fin']))
                $evento->hora_fin=Carbon::parse($datos['hora_fin'])->format('H:i:s');
            else
                $evento->hora_fin= Carbon::parse($request->hora_inicio)->addHours(6)->format('H:i:s');
            if(isset($datos['descripcion']))$evento->descripcion = $datos['descripcion'];
    
            
            $evento->save();        
            if(isset($datos['servicios'])){
                //falta checar si le mandaron varios o uno
                $serviciosSeleccionados = $datos['servicios'];
                $evento->servicios()->attach($serviciosSeleccionados);
            }
            $evento->load('servicios', 'fotos');
            return response()->json($evento);
    
        }else{
            return response()->json("El usuario actual no puede actualizar este evento",403);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evento  $evento)
    {
        $this->authorize('delete', $evento);
        if ($evento) {
            $evento->delete();
            return response()->json($evento,200);
        }else
        {
            return response()->json($evento,400);
        }
    }


    /**
     * Confirmar un evento
     */
    public function confirmar(ConfirmarEventoRequest $request, Evento $evento)
    {
        $usuario = Auth::getUser();
        if(Gate::allows('confirmar' , $evento )){  
            Log::channel('debug')->info("Confirmando");
            $evento->confirmacion = "confirmado";
            $evento->gerente_id = $usuario->id;
            if(  isset($request->precio) ) $evento->precio  =  $request->precio;            
            $evento->motivo = NULL;
            $evento->save();
            return response()->json($evento);

        }else{
            return response()->json("Solo el gerente puede confirmar eventos",403);
        }
    }


    /**
     * Rechazar un evento
     */
    public function rechazar(RechazarEventoRequest $request,  Evento $evento)
    {
        $usuario = Auth::getUser();
        if(Gate::allows('rechazar' , $evento )){  
            Log::channel('debug')->info("rechazando");
            $evento->confirmacion = "rechazado";
            $evento->gerente_id = $usuario->id;
            $evento->motivo = $request->motivo;
            $evento->save();
            return response()->json($evento);
        }else{
            return response()->json("Solo el gerente puede rechazar eventos",403);
        }
    }

}