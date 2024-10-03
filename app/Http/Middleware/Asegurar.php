<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Usuario;

class Asegurar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('paso por el middleare.');
        $authorizationHeader = $request->header('Authorization');
        // Realizar la lógica de verificación del token aquí
        // Normalmente, el token estará en el formato "Bearer tu_token_aqui"
        $token = str_replace('Bearer ', '', $authorizationHeader);
        $usuario = Usuario::where('token',$token)->first();
        /*
            checar la hora actual y ver el $usuario->expires_at
            si ya expiro el token return 401 
            si no continuar
        */

        $ret = "";
        if($usuario )
        {
            if ($usuario->expiracion > time()) {
                //return ($usuario->id);
                auth()->setUser($usuario);
                //http_response_code(299);
                //dump($usuario . 'hora');
                return $next($request);
            }else{
                return response()->json(["errors" => "Debe autenticar nuevamente"],401);
            }
        }else{
            return response()->json(["errors"=> "Debe autenticar primero $ret" ],401);
        }
    }
}
