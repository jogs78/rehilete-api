<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EventoFotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Evento $evento)
    {
        $usuario = Auth::getUser();
        if (! $evento->realizado) {
            return response()->json('Sin fotos, el evento no se ha realizado');
        }
        Log::channel('debug')->info($usuario->rol);

        switch ($usuario->rol) {
            case 'Gerente':
                $fotos = $evento->fotos;
                break;
            case 'Cliente':
                Log::channel('debug')->info("$evento->usuario_id == $usuario->id");

                if ($evento->usuario_id == $usuario->id) {
                    $fotos = $evento->fotos;
                } else {
                    return response()->json('Este evento no le pertenece al usuario', 404);
                }

                Log::channel('debug')->info('fotos:'.$fotos->tojson());

                break;
            case 'Empleado':
                $fotos = $evento->fotos;
                break;
            default:
                return response()->json('No se encontraron fotos, no se ubica al usuario actual', 404);
                break;
        }
        if ($fotos->isEmpty()) {
            return response()->json(['message' => 'Listado vacío, no hay fotos']);
        } else {
            return response()->json($fotos);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Evento $evento)
    {

        //debe venir: la foto que es el archivo y una descripcion que puede ser nulla y en caso de existir es un texto
        ob_start();
        var_dump($request->file('fotos'));
        $salida = ob_get_clean();
        Log::channel('debug')->info("fotos: $salida");
        Log::channel('debug')->info('del evento:'.$evento->id);
        $usuario = Auth::getUser();
        foreach ($request->file('fotos') as $imagen) {
            $nombre = time().rand(1, 100).'.'.$imagen->extension();
            Log::channel('debug')->info("IMAGEN : $nombre ");
            $imagen->storeAs('', $nombre, 'privadas');

            $foto = new Foto;
            $foto->ruta = $nombre;
            $foto->nombre = $imagen->getClientOriginalName();
            $foto->usuario_id = $usuario->id;
            $foto->evento_id = $evento->id;
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

            return response()->json('Foto Privada eliminada correctamente', 200);
        } else {
            return response()->json('No se pudo eliminar la Foto Privada', 400);
        }
    }
}
