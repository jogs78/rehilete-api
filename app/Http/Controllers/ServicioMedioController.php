<?php

namespace App\Http\Controllers;

use App\Models\Medio;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ServicioMedioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Servicio $servicio)
    {
        return response()->json($servicio->imagenes()->select('medios.id', 'medios.nombre')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Servicio $servicio)
    {
        $this->authorize('create', Medio::class);
        Log::channel('debug')->info('store de medio en servicios.');
        Log::channel('debug')->info('al servicio:'.$servicio->toJson());
        $usuario = Auth::getUser();
        $medio = $request->file('imagen');
            Log::channel('debug')->info('IMAGEN x.');
            $nombre = time().rand(1, 100).'.'.$medio->extension();
            $medio->storeAs('', $nombre, 'publicas');
            $imagen = new Medio;
            $imagen->ruta = $nombre;
            $imagen->nombre = $medio->getClientOriginalName();
            $imagen->usuario_id = $usuario->id;
            $imagen->descripcion = $request->descripcion;
            $imagen->save();
        $servicio->imagenes()->attach($imagen->id);
        $ultimaImagen = $servicio->imagenes()->orderBy('created_at', 'desc')->first();
        return response()->json($ultimaImagen);
    }

    /**
     * Display the specified resource.
     */
    public function show(Servicio $servicio, Medio $medio)
    {
        if ($medio) {
            return response()->download(public_path('fotos').'/'.$medio->ruta);
        }

        return response()->download('No existe');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Servicio $servicio, Medio $medio)
    {
        $this->authorize('create', Medio::class);
        if ($medio) {
            Storage::disk('publicas')->delete($medio->ruta);
            $medio->delete();
            $servicio->imagenes()->detach($medio->id);
            return response()->json($medio);
        } else {
            return response()->json('No se pudo eliminar la Imagen Publica', 400);
        }
    }
}

        /*
        ob_start();
        var_dump($agregados);
        $cadena_var_dump = ob_get_clean();
        Log::channel('debug')->info('agregados: ' . $cadena_var_dump );
        */
