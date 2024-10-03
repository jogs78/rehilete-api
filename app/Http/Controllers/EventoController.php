<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Usuario;
use App\Models\Paquete;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $authorizationHeader = $request->header('Authorization');
        // Realizar la lógica de verificación del token aquí
        // Normalmente, el token estará en el formato "Bearer tu_token_aqui"
        $token = str_replace('Bearer ', '', $authorizationHeader);
        $usuario = Usuario::where('token',$token)->first();
        //$servicios = Servicio::with('nombre')->find('id');
        //dd();
        //return response()->json([$usuario->rol],299);

       

//        $usuario = $request->user()->rol;
        
        $eventos2 = Evento::where('id','usuario_id')->get();
        $paquetes = Paquete::pluck('id','nombre');
        switch ($usuario->rol) {
            case 'Gerente':
                $eventos = Evento::with('servicios', 'fotos')->all();
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

        $servicios = Servicio::pluck('id','nombre');
        $datosPivot = DB::table('evento_servicio')->get();
        $datosPaq = DB::table('paquete_servicio')->get();
        //$eventosServicios = $eventos->servicios;
        //$eventos = DB::table('eventos')->get();

        
/*
        return response()->json([
            'servicios'=> $servicios,
            'eventos'=> $eventos,
            'datosextras'=> $datosPivot,
            'paquetes'=> $paquetes,
            'datospaquetes'=> $datosPaq,
        ]);
 */
    return response()->json($eventos);

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

        //checar quien puede crear un evento
        $usuario = Auth::getUser();
        $hora_inicial = Carbon::parse($request->hora_inicio);
        $hora_final = $hora_inicial->addHours(6);


        $this->authorize('create', Evento::class);
        $evento = new Evento();
        $evento->nombre = $request->nombre;
        $evento->usuario_id = $usuario->id;
        $evento->paquete_id = $request->paquete_id;
        $evento->paquete_precio = Paquete::find($request->paquete_id)->precio;
        $evento->precio = 0;// $request->precio;
        $evento->fecha = date($request-> fecha);
        $evento->hora_inicio = $hora_inicial->format('H:i:s');
        $evento->hora_fin = $hora_final->format('H:i:s');
        $evento->descripcion = $request->descripcion;
        $evento->num_personas = $request->num_personas; //en teoria deberia dar error si es mas de 100
        $evento->save();
        $acumulado = $evento->paquete_precio;
        $evento = Evento::find($evento->id);
        if(isset($request -> idservicios)){
            $serviSelect = $request -> idservicios;
            foreach ($serviSelect as $servi) {
                $servicio = Servicio::find($servi);
                $acumulado += $servicio->precio;
                $evento -> servicios() -> attach($servi,['servicio_precio'=> $servicio->precio]);
            }
            $evento->precio = $acumulado;
            $evento->save();
            $evento->load('servicios');
        }
        return response()->json($evento,200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $r, $id)
    {

//        $usuario = Auth::getUser();
//        return response()->json($usuario);
//        Log::channel('debug')->info('Este es un mensaje informativo.');
        $evento = Evento::with('servicios', 'fotos')->find($id);
        $this->authorize('view',$evento );
//        with('servicios')

//        return response()->json($id);
       
        return response()->json($evento);
//        return $evento->toJson();
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $evento = Evento::find($id);

        $this->authorize('view',$evento );

        //$usuario = $request->user();
        //return $usuario;
        $this->authorize('update', $evento);
        $evento->nombre = $request->nombre;
        $evento->usuario_id = $request->usuario_id;
        $evento->paquete_id = $request->paquete_id;
        $evento->precio = $request->precio;
        $evento->fecha = date($request-> fecha);
        $evento->hora_inicio = Carbon::parse($request->hora_inicio)->format('H:i:s');
        $evento->hora_fin = Carbon::parse($request->hora_fin)->format('H:i:s');
        $evento->descripcion = $request->descripcion;
        $evento->num_personas = $request->num_personas;
        $evento->save();
        
        $evento = Evento::find($evento->id);
        $serviSelect = $request -> idservicio;
        $evento->servicios()->attach($serviSelect);
        $evento->load('servicios', 'fotos');
        return response()->json($evento);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', Evento::find($id));
        $evento = Evento::find($id);
        if ($evento) {
            $evento->delete();
            return response()->json(["success"=> "Evento eliminado correctamente"],200);
        }else
        {
            return response()->json(["errors"=> "No se pudo eliminar el Evento"],400);
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
