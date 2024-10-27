<?php

namespace App\Policies;

use App\Models\Abono;
use App\Models\Evento;
use App\Models\Usuario as User;
use Illuminate\Auth\Access\Response;

class AbonoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Evento $evento): bool
    {
        if ($user->rol == 'Gerente' || $user->rol == 'Empleado') {
            return true;
        } else {
            // Puedes ahora usar $evento en la lógica de autorización
            return $user->id === $evento->user_id; // ejemplo de validación
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->rol == 'Gerente' || $user->rol == 'Empleado') {
            return true;
        } else return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Abono $abono): bool
    {
        if ($user->rol == 'Gerente' ) {
            return true;
        } else return false;
    }

}
