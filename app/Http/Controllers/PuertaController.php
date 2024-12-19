<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PuertaController extends Controller
{
    public function entrada(Request $request)
    {
        $user = $request->nombre_usuario;
        $passw = $request->passw;
        Log::channel('debug')->info("Usuario".$user.", contraseña:".$passw);

        //dd($user,$passw);

        $usuario = Usuario::where('nombre_usuario', $user)->first();
        if ($usuario) {
            if (Hash::check($passw, $usuario->contraseña)) {
                $usuario->token = Str::random();
                $segundos = (1 * 60 * 60); 
                $usuario->expiracion = time() + $segundos;
                Auth::loginUsingId($usuario->id);
                $usuario->save();
                $usuario->segundos=$segundos;
                return response()->json($usuario, 200);
            } else {
                return response()->json('Contraseña o usuario no encontrado', 400);
            }
        } else {
            return response()->json('Usuario o contraseña no encontrado', 400);
        }
    }

    public function salida(Request $request)
    {
        $authorizationHeader = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $authorizationHeader);
        $rtoken = $request->token;
        $usuario = Usuario::where('token', $token)->first();

        if ($usuario->token == $token) {
            $usuario->token = null;
            $usuario->expiracion = null;
            $usuario->save();
            Auth::logout();

            return response()->json(['exito' => 'el usuario cerro sesion']);
        } else {
            return response()->json(['error' => 'el usuario '.$usuario->nombre_usuario.' no coincide su token ('.$usuario->token.') ('.$token.'), no se puede cerrar sesion'], 401);
        }
    }
}
