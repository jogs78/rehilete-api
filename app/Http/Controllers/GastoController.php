<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Gasto;
use App\Models\Paquete;
use App\Models\Servicio;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GastoController extends Controller
{
    public function __construct()
    {
        // Llama al método de actualización de estados al construir la instancia del controlador
        //$this->actualizarEstadoEventos();
    }

    public function actualizarEstadoEventos()
    {
        // Obtén los eventos confirmados que cumplen con la condición
        $eventosPendientes = Evento::where('estado', 'validado')
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
    public function index()
    {
        $usuario = auth()->User();
        $evRealizados = Evento::where('realizado', true)->get();
        //return $evRealizados->toJson();
        $paquetes = Paquete::pluck('id', 'nombre');
        $servicios = Servicio::pluck('id', 'nombre');
        $datosPivot = DB::table('evento_servicio')->get();
        $datosPaq = DB::table('paquete_servicio')->get();
        $gastos = Gasto::all();

        /*switch ($usuario->rol) {
            case 'Gerente':
                $privadas = Gasto::where('evento_id' , $evento)->get();
                break;
            case 'Cliente':
                $privadas = Gasto::where('usuario_id', $usuario->id)->where('evento_id' , $evento)->get();
                break;
            case 'Empleado':
                $privadas = Gasto::where('usuario_id', $usuario->id)->where('evento_id' , $evento)->get();
                break;
            default:
                # code...
                break;
        }*/

        return response()->json([
            'servicios' => $servicios->toJson(),
            'evRealizados' => $evRealizados->toJson(),
            'datosextras' => $datosPivot->toJson(),
            'paquetes' => $paquetes->toJson(),
            'datospaquetes' => $datosPaq->toJson(),
            'gastos' => $gastos->toJson(),
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
        $gasto = new Gasto;
        $gasto->evento_id = $request->evento_id;
        $gasto->descripcion = $request->descripcion;
        $gasto->cantidad = $request->cantidad;
        $gasto->save();

        return response()->json(['exito' => 'No hay errores'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $gasto = Gasto::find($id);

        return $gasto->toJson();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $gasto = Gasto::find($id);
        $gasto->evento_id = $request->evento_id;
        $gasto->descripcion = $request->descripcion;
        $gasto->cantidad = $request->cantidad;
        $gasto->save();

        return $gasto->toJson();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gasto = Gasto::find($id);
        if ($gasto) {
            $gasto->delete();

            return response()->json(['exito' => 'Evento eliminado correctamente'], 200);
        } else {
            return response()->json(['error' => 'No se pudo eliminar el Evento'], 400);
        }
    }
}
