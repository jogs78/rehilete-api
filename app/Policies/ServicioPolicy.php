<?php

namespace App\Policies;

use App\Models\Servicio;
use App\Models\Usuario;
use Illuminate\Auth\Access\Response;

class ServicioPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Usuario $user): bool
    {
        if($user->rol == "Gerente") return true;
        else return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Usuario $user, Servicio $servicio): bool
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
    public function update(Usuario $user, Servicio $servicio): bool
    {
        //if($user->rol == 'Gerente') return true;
        //else return false;
        return $user->rol === 'Gerente';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Usuario $user, Servicio $servicio): bool
    {
        return $user->rol === 'Gerente';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Usuario $user, Servicio $servicio): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Usuario $user, Servicio $servicio): bool
    {
        //
    }
}
