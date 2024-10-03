<?php

namespace App\Policies;

use App\Models\Paquete;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Auth\Access\Response;

class PaquetePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Usuario $user): bool
    {
        if ($user->rol == "Gerente") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Usuario $user, Paquete $paquete): bool
    {
        //
    }

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

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Usuario $user, Paquete $paquete): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Usuario $user, Paquete $paquete): bool
    {
        //
    }
}
