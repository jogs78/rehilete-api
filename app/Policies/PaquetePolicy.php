<?php

namespace App\Policies;

use App\Models\Paquete;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Auth\Access\Response;

class PaquetePolicy
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
    public function update(Usuario $user, Paquete $paquete): bool
    {
        return $user->rol === 'Gerente';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Usuario $user, Paquete $paquete): bool
    {
        return $user->rol === 'Gerente';
    }
}
