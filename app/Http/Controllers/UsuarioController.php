<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Medio;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUsuarioRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Usuario::class );
        $usuarios = Usuario::all();
        return response()->json($usuarios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUsuarioRequest $request)
    {


        $this->authorize('create', Usuario::class );
        $usuario = new Usuario();
        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->nombre_usuario = $request->nombre_usuario;
        $usuario->contraseña = Hash::make($request->passw);
        $usuario->rol = $request->rol;
        $usuario->fecha_nacimiento = $request->fecha_nacimiento;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;
        if ($request->hasFile('avatar')) {
            $imagen = $request->file('avatar');
            $nombre = time().rand(1,100).'.'.$imagen->extension();
            $imagen->storeAs('', $nombre,'avatares');
            $usuario->avatar = $nombre;
        }
        $usuario->save();
        return response()->json($usuario);
    }

    /**
     * Display the specified resource.
     */
    public function show(Usuario $usuario)
    {
        //$usuario->load('eventos');
        return response()->json($usuario);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usuario $usuario)
    {
        
        $this->authorize('update', $usuario );
        $usuario->fill($request->all());
        if (is_null($request->passw)) $usuario->contraseña = Hash::make($request->passw);
/*
        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->nombre_usuario = $request->nombre_usuario;
        $usuario->rol = $request->rol;
        $usuario->fecha_nacimiento = $request->fecha_nacimiento;
        $usuario->direccion = $request->direccion;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;
*/      $resp = $request->hasFile('avatar');
        Log::channel('debug')->info("file:" . $resp . ':');
        if ($request->hasFile('avatar')) {
            Log::channel('debug')->info("Usuario envio avatar:" );

            $imagen = $request->file('avatar');
            $nombre = time().rand(1,100).'.'.$imagen->extension();
            $imagen->storeAs('', $nombre,'avatares');
            $usuario->avatar = $nombre;
        }
        $usuario->save();
        return response()->json($usuario);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuario $usuario)
    {
        $this->authorize('delete', $usuario );
        if($usuario->eventos()->count()>0){
            return response()->json("Imposible eliminar", 409);
        }else{
            $usuario->delete();
            return response()->json($usuario);
        }
    }

    public function verAvatar(Usuario $usuario)
    {
        $this->authorize('verAvatar', $usuario );
        Log::channel('debug')->info("Usuario ver avatar:" . $usuario->toJson());
        if ( is_null ($usuario->avatar)){
            return response()->download(storage_path('app/avatares').'/null.jpg');
        }else{
            return response()->download(storage_path('app/avatares').'/'.$usuario->avatar);
        }
    }
    public function subirAvatar(Request $request, Usuario $usuario)
    {
        $this->authorize('subirAvatar', $usuario );
        if ($request->hasFile('avatar')) {
            $imagen = $request->file('avatar');
            $nombre = time().rand(1,100).'.'.$imagen->extension();
            $imagen->storeAs('', $nombre,'avatares');
            $usuario->avatar = $nombre;
        }
        $usuario->save();
        //return $usuario->toJson();
        return response()->json($usuario);
    }
    public function borrarAvatar(Request $request, Usuario $usuario)
    {
        $this->authorize('borrarAvatar', $usuario );
        Log::channel('debug')->info("Usuario BORRAR avatar:" . $usuario->toJson());
        if ( !is_null ($usuario->avatar))$usuario->avatar=NULL;
        $usuario->save();
        //return $usuario->toJson();
        return response()->json($usuario);
    }
}