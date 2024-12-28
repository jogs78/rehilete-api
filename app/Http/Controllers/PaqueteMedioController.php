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
        //Log::channel('debug')->info(json_encode($request->file('imagenes')));

        $usuario = Auth::getUser();
        $agregados = [];
        $medio = $request->file('imagen');
            Log::channel('debug')->info('IMAGEN x.');
            $nombre = time().rand(1, 100).'.'.$medio->extension();
            $medio->storeAs('', $nombre, 'publicas');
            //Storage::disk('publicas')->putFile('', $medio, $nombre);
            $imagen = new Medio;
            $imagen->ruta = $nombre;
            $imagen->nombre = $medio->getClientOriginalName();
            $imagen->usuario_id = $usuario->id;
            $imagen->descripcion = $request->descripcion;
            $imagen->save();
//            array_push($agregados, $imagen->id);
        /*
        ob_start();
        var_dump($agregados);
        $cadena_var_dump = ob_get_clean();
        Log::channel('debug')->info('agregados: ' . $cadena_var_dump );
        */
        $paquete->imagenes()->attach($imagen->id);
//        $paquete->load('imagenes');
        $ultimaImagen = $paquete->imagenes()->orderByDesc('usables.created_at')->first();
        return response()->json($ultimaImagen);

//        return response()->json($paquete->imagenes()->select('medios.id', 'medios.nombre')->get());
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

            return response()->json($paquete->imagenes()->select('medios.id', 'medios.nombre')->get());
        } else {
            return response()->json('No se pudo eliminar la Imagen Publica', 400);
        }
    }
}
