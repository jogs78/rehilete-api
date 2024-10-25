<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Paquete;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreEventoRequest;
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
            //checar quien puede crear un evento
            $usuario = Auth::getUser();
            $gerente = $usuario->rol == 'Gerente';

            ob_start();
            var_dump($gerente);
            $salida = ob_get_clean();
            Log::channel('debug')->info('gerente:' . $salida);


            $hora_inicial = Carbon::parse($request->hora_inicio.":00");

            $hora_final = $gerente ?  Carbon::parse($request->hora_fin.":00") : $hora_inicial->addHours(6);

            $evento = new Evento();
            $evento->nombre = $request->nombre;
            $evento->usuario_id = $gerente ? $request->usuario_id : $usuario->id;
            $evento->paquete_id = $request->paquete_id;
            $evento->paquete_precio = Paquete::find($request->paquete_id)->precio;
            $evento->precio = 0;// $request->precio;
            $evento->fecha = date($request-> fecha);
            $evento->hora_inicio = $hora_inicial->format('H:i:s');
            $evento->hora_fin = $gerente ? $request->usuario_id : $usuario->id; $hora_final->format('H:i:s');
            $evento->descripcion = $request->descripcion;
            $evento->num_personas = $request->num_personas; //en teoria deberia dar error si es mas de 100
            $evento->save();
            $acumulado = $evento->paquete_precio;
    //        $evento = Evento::find($evento->id);

            if(isset($request -> servicios)){
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
                $evento->precio = $acumulado;
                $evento->save();
                $evento->load('servicios');
    
            return response()->json($evento);

        }else{
            return response()->json("Solo el gerente puede confirmar eventos",403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $r, Evento  $evento)
    {

//        $usuario = Auth::getUser();
//        return response()->json($usuario);
//        Log::channel('debug')->info('Este es un mensaje informativo.');
        $evento->load('servicios', 'fotos');
        $this->authorize('view',$evento );
//        with('servicios')

//        return response()->json($id);
       
        return response()->json($evento);
//        return $evento->toJson();
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evento  $evento)
    {
        $this->authorize('update', $evento);
        $datos=$request->all();
        if(isset($datos['fecha']))$datos['fecha']=date($datos['fecha']);
        if(isset($datos['hora_inicio']))$datos['hora_inicio']=Carbon::parse($datos['hora_inicio'])->format('H:i:s');
        if(!isset($datos['hora_fin'])){
            $datos['hora_fin'] = $hora_inicial = Carbon::parse($request->hora_inicio)->addHours(6)->format('H:i:s');
        }else $datos['hora_fin']=Carbon::parse($datos['hora_fin'])->format('H:i:s');
        $evento->save();        
        if(isset($datos['idservicio'])){
            //falta checar si le mandaron varios o uno
            $serviciosSeleccionados = $datos['idservicio'];
            $evento->servicios()->attach($serviciosSeleccionados);
        }
        $evento->load('servicios', 'fotos');
        return response()->json($evento);
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

    //LA INTENCION ES QUE LA COMUNICACION CON EL API SEA DIRECTA Y SIN DEPENDENCIAS
    public function actualizarEstatus(Request $request, string $id){
        $evento = Evento::find($id);
        $evento->confirmacion = $request->confirmacion;
        $evento->gerente_id = $request->gerente_id;
        $evento->save();

        return $evento->toJson();
    }

    /**
     * Confirmar un evento
     */
    public function confirmar(Evento $evento)
    {
        $usuario = Auth::getUser();
        if(Gate::allows('confirmar' , $evento )){  
            Log::channel('debug')->info("Confirmando");
            $evento->confirmacion = "confirmado";
            $evento->gerente_id = $usuario->id;
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

     //implementar el form request
    public function rechazar(Request $request,  Evento $evento)
    {
        $usuario = Auth::getUser();
        if(Gate::allows('confirmar' , $evento )){  
            Log::channel('debug')->info("rechzando");
            $evento->confirmacion = "rechazado";
            $evento->gerente_id = $usuario->id;
            $evento->motivo = $request->motivo;
            $evento->save();
            return response()->json($evento);
        }else{
            return response()->json("Solo el gerente puede confirmar eventos",403);
        }

        if ($usuario->rol == 'Gerente' ) {
            $evento->confirmacion = "rechazado";
            $evento->gerente_id = $usuario->id;
            $evento->motivo = $request->motivo;
            $evento->save();
        }else{
            return response()->json("Solo el gerente puede rechazar eventos",403);

        }
    }

}
