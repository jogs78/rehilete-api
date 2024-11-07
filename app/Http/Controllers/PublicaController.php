<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Paquete;
use App\Models\Publica;
use App\Models\Servicio;
use App\Models\Usable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PublicaController extends Controller
{
    public function __construct()
    {
        // Llama al método de actualización de estados al construir la instancia del controlador
        //$this->actualizarEstadoEventos();
    }

    //esto debe ir a un cron job
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

    //para que es esto, no debe responder con varias cosas...
    public function index2()
    {
        $evRealizados = Evento::where('realizado', true)->get();
        //return $evRealizados->toJson();
        $paquetes = Paquete::pluck('id', 'nombre');
        $servicios = Servicio::pluck('id', 'nombre');
        $datosPivot = DB::table('evento_servicio')->get();
        $datosPaq = DB::table('paquete_servicio')->get();

        return response()->json([
            'servicios' => $servicios->toJson(),
            'evRealizados' => $evRealizados->toJson(),
            'datosextras' => $datosPivot->toJson(),
            'paquetes' => $paquetes->toJson(),
            'datospaquetes' => $datosPaq->toJson(),
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Publica::whereNotIn('id', Usable::pluck('publica_id'))->get();
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
        //        Log::channel('debug')->info('entra post.');
        //        Log::channel('debug')->info(json_encode($request->file('imagenes')));
        $usuario = Auth::getUser();

        foreach ($request->file('imagenes') as $image) {
            Log::channel('debug')->info('IMAGEN x.');

            $imgName = time().rand(1, 100).'.'.$image->extension();

            $image->storeAs('', $imgName, 'publicas');
            //Storage::disk('publicas')->putFile('', $image, $imgName);

            $imagen = new Publica;
            $imagen->ruta = $imgName;
            $imagen->nombre = $image->getClientOriginalName();
            $imagen->usuario_id = $usuario->id;
            $imagen->descripcion = $request->descripcion;
            $imagen->save();
            //print_r("Hola");
            //return;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Publica $publica)
    {
        return $publica->toJson();
    }

    public function show2(Publica $publica)
    {
        return response()->download(public_path('fotos').'/'.$publica->ruta);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publica $publica)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publica $publica)
    {
        $publica->usuario_id = $request->usuario_id;
        $publica->descripcion = $request->descripcion;
        $publica->save();

        return $publica->toJson();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publica $publica)
    {
        if ($publica) {
            Storage::disk('publicas')->delete($publica->ruta);
            $publica->delete();

            return response()->json(['exito' => 'Foto Publica eliminada correctamente'], 200);
        } else {
            return response()->json(['error' => 'No se pudo eliminar la Foto Publica'], 400);
        }
    }
}
