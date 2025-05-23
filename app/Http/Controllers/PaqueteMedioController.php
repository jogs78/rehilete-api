<?php

namespace App\Http\Controllers;

use App\Models\Medio;
use App\Models\Paquete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PaqueteMedioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Paquete $paquete)
    {
        //return response()->json($paquete->imagenes);
        return response()->json($paquete->imagenes()->select('medios.id', 'medios.nombre')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Paquete $paquete)
    {
        $this->authorize('create', Medio::class);
        Log::channel('debug')->info('store de medio en paquetes.');
        Log::channel('debug')->info('al paquete:'.$paquete->toJson());
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
        $paquete->imagenes()->attach($imagen->id);
        $ultimaImagen = $paquete->imagenes()->orderBy('created_at', 'desc')->first();
        return response()->json($ultimaImagen);
    }

    /**
     * Display the specified resource.
     */
    public function show(Paquete $paquete, Medio $medio)
    {
        if ($medio) {
            return response()->download(public_path('fotos').'/'.$medio->ruta);
        }

        return response()->download('No existe');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paquete $paquete, Medio $medio)
    {
        $this->authorize('create', Medio::class);
        if ($medio) {
            Storage::disk('publicas')->delete($medio->ruta);
            $medio->delete();
            //aqui como lo elimino debo poner un detach
            $paquete->imagenes()->detach($medio->id);
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
