<?php

namespace App\Policies;

use App\Models\Gasto;
use App\Models\Evento;
use App\Models\Usuario;
use Illuminate\Support\Facades\Log;
class GastoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Usuario $usuario, Evento $evento): bool
    {
        Log::channel('debug')->info("Dentro de la politica viewAny \n\tuser:" . $usuario->toJson() . ", \n\tevento:" . $evento->toJson());

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
    public function view(Usuario $usuario, Gasto $gasto): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Usuario $usuario, Evento $evento): bool
    {
        return $usuario->rol == 'Gerente' && $evento->gerente_id == $usuario->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Usuario $usuario, Gasto $gasto): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Usuario $usuario, Gasto $gasto, Evento $evento): bool
    {
        return $usuario->rol == 'Gerente' && $evento->gerente_id == $usuario->id;
    }
}
