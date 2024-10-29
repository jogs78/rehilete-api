<?php

namespace App\Policies;

use App\Models\Paquete;
use App\Models\User;
use App\Models\Usuario;

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
        if ($user->rol === 'Gerente') {
            if ($paquete->eventosConfirmadosPendientes->count() > 0) {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Usuario $user, Paquete $paquete): bool
    {
        if ($user->rol === 'Gerente') {
            if ($paquete->eventosConfirmadosPendientes->count() > 0) {
                return false;
            }

            return true;
        }

        return false;

    }
}
