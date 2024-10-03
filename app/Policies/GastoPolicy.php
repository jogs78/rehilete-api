<?php

namespace App\Policies;

use App\Models\Gasto;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Auth\Access\Response;

class GastoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Usuario $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Usuario $user, Gasto $gasto): bool
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
    public function update(Usuario $user, Gasto $gasto): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Usuario $user, Gasto $gasto): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Gasto $gasto): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Gasto $gasto): bool
    {
        //
    }
}
