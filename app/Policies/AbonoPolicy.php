<?php

namespace App\Policies;

use App\Models\Abono;
use App\Models\Evento;
use App\Models\Usuario;
use Illuminate\Support\Facades\Log;

class AbonoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Usuario $usuario, Evento $evento): bool
    {
        Log::channel('debug')->info("Dentro de la politica viewAny \n\tuser:".$usuario->toJson().", \n\tevento:".$evento->toJson());

        if ($usuario->rol == 'Gerente' || $usuario->rol == 'Empleado') {
            return true;
        } else {
            // Puedes ahora usar $evento en la lógica de autorización
            return $usuario->id == $evento->user_id; // ejemplo de validación
        }
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(Usuario $usuario, Abono $abono): bool
    {

        return $usuario->rol == 'Gerente' || ( $usuario->rol == 'Cliente' && $usuario->id == $abono->evento->usuario_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Usuario $usuario): bool
    {
        if ($usuario->rol == 'Gerente' || $usuario->rol == 'Empleado') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Usuario $usuario, Abono $abono): bool
    {
        if ($usuario->rol == 'Gerente') {
            return true;
        } else {
            return false;
        }
    }
}
