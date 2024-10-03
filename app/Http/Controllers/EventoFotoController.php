<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Foto;
use Illuminate\Http\Request;
use App\Models\Paquete;
use App\Models\Servicio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;



class EventoFotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Evento $evento)
    {
        Log::channel('debug')->info("listar en el evento: " . $evento->tojson());
        $usuario = Auth::getUser();
        if(!$evento->realizado){
            return response()->json("Sin fotos, el evento no se ha realizado");
        } 
        Log::channel('debug')->info($usuario->rol);

        switch ($usuario->rol) {
            case 'Gerente':
                $fotos = $evento->fotos;
            break;
            case 'Cliente':
                Log::channel('debug')->info("$evento->usuario_id == $usuario->id");

                if ($evento->usuario_id == $usuario->id) 
                    $fotos = $evento->fotos;
                else 
                    return response()->json("Este evento no le pertenece al usuario",404);

                Log::channel('debug')->info("fotos:" . $fotos->tojson());

            break;
            case 'Empleado':
                $fotos = $evento->fotos;
            break;
            default:
                return response()->json("No se encontraron fotos, no se ubica al usuario actual",404);
            break;
        }
        return response()->json($fotos);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Evento $evento)
    {
        Log::channel('debug')->info("fotos:" . json_encode($request->file('imagenes')));
        Log::channel('debug')->info("del evento:" . $evento->id);
        $usuario = Auth::getUser();
        foreach ($request->file('imagenes') as $imagen) {
            Log::channel('debug')->info('IMAGEN x.');
            $nombre = time().rand(1,100).'.'.$imagen->extension();
            $imagen->storeAs('', $nombre,'privadas');

            $foto = new Foto();
            $foto->ruta = $nombre;
            $foto->nombre = $imagen->getClientOriginalName();
            $foto->usuario_id= $usuario->id;
            $foto->evento_id= $evento->id;
            $foto->descripcion = $request->descripcion;
            $foto->save();
        }
        $evento->load('fotos');
        return response()->json($evento);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evento $evento, Foto $foto)
    {
        if ($foto) {
            Storage::disk('privadas')->delete($foto->ruta);
            $foto->delete();
            return response()->json("Foto Privada eliminada correctamente",200);
        }else
        {
            return response()->json("No se pudo eliminar la Foto Privada",400);
        }
    }
}
