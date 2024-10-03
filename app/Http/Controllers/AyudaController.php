<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AyudaController extends Controller
{
    public function registroUsuario(Request $request)
    {
        $usuario = new Usuario();
        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->nombre_usuario = $request->nombre_usuario;
        $usuario->contraseña = Hash::make($request->passw);
        $usuario->rol = "Cliente"; // no se debe poder especificar el rol  $request->rol; 
        $usuario->fecha_nacimiento = $request->fecha_nacimiento;
        //$usuario->direccion = $request->direccion;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;
        $usuario->save();
        return response()->json([$usuario],200);
    }
    public function inicializar() {
        Artisan::call('db:wipe');
        Artisan::call('migrate', 
        [
           '--seed' => true,
           '--force' => true
        ]);
        
    }
}
