<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Foto;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFotoRequest;
use App\Http\Requests\UpdateFotoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
class EventoFotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Evento $evento)
    {
        $usuario = Auth::getUser();
        Log::channel('debug')->info("ve fotos un: $usuario->rol");

        if (Gate::allows('viewAny', [Foto::class, $evento])){
            Log::channel('debug')->info("\tSi puede");
            if ( $evento->realizado  ||  !$evento->enRangoHorario()) {
                return response()->json('Este evento no se encuentra en reliazcion ni realizado', 422);
            }
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
                    return response()->json('No se encontraron fotos, no se ubica al rol del usuario actual', 404);
                    break;
            }
            if ($fotos->isEmpty()) {
                Log::channel('debug')->info("\tevento: $evento->id" );
                return response()->json(['message' => 'Listado vacío, no hay fotos']);
            } else {
                return response()->json($fotos);
            }                
        } else {
            return response()->json('Este usuario no puede ver las fotos del evento seleccionado', 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFotoRequest $request, Evento $evento)
    {
        /*
        debe venir: la foto que es el archivo 
        y una descripcion que puede ser nulla y en caso de existir es un texto
        */

        if (Gate::allows('create', [Foto::class, $evento])){
            ob_start();
            var_dump($request->file('foto'));
            $salida = ob_get_clean();
            Log::channel('debug')->info("foto: $salida");
            Log::channel('debug')->info('del evento:'.$evento->id);
            $usuario = Auth::getUser();
            $imagen = $request->file('foto');
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
            $evento->load('fotos');
    
            return response()->json($evento);
    
        }else {
            return response()->json('Este usuario no puede agregar fotos al evento seleccionado', 403);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Evento $evento, Foto $foto)
    {
        if(Gate::allows('view',[$foto,$evento]))
            return response()->download(storage_path('app/privadas').'/'.$foto->ruta);
        else
            return response()->json("El usuario actual no puede ver esta foto", 403);
    }

    public function descripcion(Evento $evento, Foto $foto)
    {
        if(Gate::allows('view',[$foto,$evento]))
            return response()->json($foto);
        else
            return response()->json("El usuario actual no puede ver esta foto", 403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFotoRequest $request, Evento $evento, Foto $foto)
    {
        if(Gate::allows('update',[$foto,$evento])){
            Log::channel('debug')->info("El usuario actual si puede editar la foto");
            $foto->descripcion = $request->descripcion;
            $foto->save();
            return response()->json($foto);

        }else
            return response()->json("El usuario actual no editar la descripcion de esta foto", 403);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evento $evento, Foto $foto)
    {
        if(Gate::allows('delete',$foto)){
            Log::channel('debug')->info("El usuario actual si puede borrar la foto");
            if ($foto) {
                Storage::disk('privadas')->delete($foto->ruta);
                $foto->delete();
                //falta manejar excepciones
            }
            return response()->json($foto);
        }else
            return response()->json("El usuario actual no puede eliminar esta foto", 403);




    }
}
