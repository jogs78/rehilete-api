<?php

namespace App\Http\Middleware;

use App\Models\Usuario;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Posible
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
        if($authorizationHeader==""){
            return $next($request);
        }

        // Realizar la lógica de verificación del token aquí
        // Normalmente, el token estará en el formato "Bearer tu_token_aqui"
        $token = str_replace('Bearer ', '', $authorizationHeader);
        $usuario = Usuario::where('token', $token)->first();
        /*
            checar la hora actual y ver el $usuario->expires_at
            si ya expiro el token return 401
            si no continuar
        */

        $ret = '';
        if ($usuario) {
            if ($usuario->expiracion > time()) {
                //return ($usuario->id);
                auth()->setUser($usuario);

                //http_response_code(299);
                //dump($usuario . 'hora');
                return $next($request);
            } else {
                return response()->json(['error' => 'Debe autenticar nuevamente'], 401);
            }
        } else {
            return response()->json(['error' => "Debe autenticar primero $ret"], 401);
        }
    }
}
