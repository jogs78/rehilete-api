<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Tag(
 *     name="Usuarios",
 *     description="Operaciones relacionadas con los usuarios"
 * )
 * 
 * @OA\Schema(
 *     schema="Usuario",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="nombre", type="string"),
 *     @OA\Property(property="email", type="string"),
 * )
 *
 */
class UsuarioController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/usuarios",
     *     summary="Listar todos los usuarios",
     *     tags={"Usuarios"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuarios obtenida con éxito",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Usuario")
     *         ) 
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Solo el gerente puede listar usuarios"
     *     )
     * )
     */
    public function index()
    {
        if (Gate::allows('viewAny', Usuario::class)) {
            $usuarios = Usuario::all();

            return response()->json($usuarios);
        } else {
            return response()->json('Solo el gerente puede listar usuarios', 403);
        }
    }

 /**
     * @OA\Post(
     *     path="/api/usuarios",
     *     summary="Crear un nuevo usuario",
     *     tags={"Usuarios"},
     *     @OA\RequestBody(
     *         required=true
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario creado con éxito",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Usuario"
     *         ) 
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Solo el gerente puede agregar usuarios"
     *     )
     * )
     */
    public function store(StoreUsuarioRequest $request)
    {
        if (Gate::allows('create', Usuario::class)) {
            $usuario = new Usuario;
            $usuario->nombre = $request->nombre;
            $usuario->apellido = $request->apellido;
            $usuario->nombre_usuario = $request->nombre_usuario;
            $usuario->contraseña = Hash::make($request->passw);
            $usuario->rol = $request->rol;
            $usuario->fecha_nacimiento = $request->fecha_nacimiento;
            $usuario->email = $request->email;
            $usuario->telefono = $request->telefono;

            ob_start();
            var_dump($request->hasFile('avatar'));
            $salida = ob_get_clean();
            Log::channel('debug')->info('hasFile?:'.$salida);

            if ($request->hasFile('avatar')) {
                $imagen = $request->file('avatar');
                $nombre = time().rand(1, 100).'.'.$imagen->extension();
                $imagen->storeAs('', $nombre, 'avatares');
                $usuario->avatar = $nombre;
                Log::channel('debug')->info('nombre:'.$nombre);

            }
            $usuario->save();

            return response()->json($usuario,201);
        } else {
            return response()->json('Solo el gerente puede crear usuarios.', 403);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Usuario $usuario)
    {
        if (Gate::allows('view', $usuario)) {
            //$usuario->load('eventos');
            return response()->json($usuario);
        } else {
            return response()->json('El usuario actual no puede ver a este usuario.', 403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUsuarioRequest $request, Usuario $usuario) //falta validar....
    {
        if (Gate::allows('update', $usuario)) {
            ob_start();
            var_dump($request->all());
            $salida = ob_get_clean();
            Log::channel('debug')->info('dump:'.$salida);

            $usuario->fill($request->all());
            if (is_null($request->passw)) {
                $usuario->contraseña = Hash::make($request->passw);
            }
            $resp = $request->hasFile('avatar');
            Log::channel('debug')->info('hay avatar?:'.$resp.':');
            if ($request->hasFile('avatar')) {
                Log::channel('debug')->info('Usuario envio avatar:');
                if (! is_null($usuario->avatar)) {
                    Storage::disk('avatares')->delete($usuario->avatar);
                    $usuario->avatar = null;
                }
                $imagen = $request->file('avatar');
                $nombre = time().rand(1, 100).'.'.$imagen->extension();
                $imagen->storeAs('', $nombre, 'avatares');
                $usuario->avatar = $nombre;
            }
            $usuario->save();

            return response()->json($usuario);
        } else {
            return response()->json('El usuario actual no puede actualizar a este usuario.', 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuario $usuario)
    {
        if (Gate::allows('delete', $usuario)) {
            if ($usuario->eventos()->count() > 0) {
                return response()->json('Imposible eliminar a este usuario', 409);
            } else {
                if (! is_null($usuario->avatar)) {
                    Storage::disk('avatares')->delete($usuario->avatar);
                    $usuario->avatar = null;
                }
                $usuario->delete();

                return response()->json($usuario);
            }
        } else {
            return response()->json('El usuario actual no puede eliminar a este usuario.', 403);
        }
    }

    public function verAvatar(Usuario $usuario)
    {
        if (Gate::allows('verAvatar', $usuario)) {
            //$usuario->load('eventos');
            //return response()->json($usuario);
            if (is_null($usuario->avatar)) {
                return response()->download(storage_path('app/avatares').'/null.png');
            } else {
                return response()->download(storage_path('app/avatares').'/'.$usuario->avatar);
            }
        } else {
            return response()->json('El usuario actual no puede ve el Avatar de este usuario.', 403);
        }
    }

    public function subirAvatar(Request $request, Usuario $usuario)
    {
        if (Gate::allows('subirAvatar', $usuario)) {
            //$usuario->load('eventos');
            if ($request->hasFile('avatar')) {
                $imagen = $request->file('avatar');
                $nombre = time().rand(1, 100).'.'.$imagen->extension();
                if (! is_null($usuario->avatar)) {
                    Storage::disk('avatares')->delete($usuario->avatar);
                    $usuario->avatar = null;
                }
                $imagen->storeAs('', $nombre, 'avatares');
                $usuario->avatar = $nombre;
            }
            $usuario->save();

            return response()->json($usuario);
        } else {
            return response()->json('El usuario actual no puede poner el Avatar de este usuario.', 403);
        }
    }

    public function borrarAvatar(Request $request, Usuario $usuario)
    {
        if (Gate::allows('borrarAvatar', $usuario)) {
            //$usuario->load('eventos');
            if (! is_null($usuario->avatar)) {
                Storage::disk('avatares')->delete($usuario->avatar);
                $usuario->avatar = null;
            }
            $usuario->save();

            return response()->json($usuario);
        } else {
            return response()->json('El usuario actual no puede borrar el Avatar de este usuario.', 403);
        }
    }
}
