<?php

namespace App\Policies;

use App\Models\Servicio;
use App\Models\Usuario;

class ServicioPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(Usuario $user): bool
    {
        return $user->rol === 'Gerente';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Usuario $user, Servicio $servicio): bool
    {
        return $user->rol === 'Gerente';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Usuario $user, Servicio $servicio): bool
    {
        return $user->rol === 'Gerente';
    }
}
