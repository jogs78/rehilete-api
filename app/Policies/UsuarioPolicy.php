<?php

namespace App\Policies;

use App\Models\Usuario;
use Illuminate\Support\Facades\Log;

class UsuarioPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Usuario $actual): bool
    {
        Log::channel('debug')->info('Usuario viewAny:'.$actual->toJson());

        return $actual->rol == 'Gerente';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Usuario $actual, Usuario $recurso): bool
    {
        return $actual->rol == 'Gerente' || $recurso->id == $actual->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Usuario $actual): bool
    {
        return $actual->rol == 'Gerente';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Usuario $actual, Usuario $recurso): bool
    {
        return $actual->rol == 'Gerente' || $recurso->id == $actual->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Usuario $actual, Usuario $recurso): bool
    {
        return $actual->rol == 'Gerente' || $recurso->id == $actual->id;
    }

    public function verAvatar(Usuario $actual, Usuario $recurso): bool
    {
        return $actual->rol == 'Gerente' || $recurso->id == $actual->id;
    }

    public function subirAvatar(Usuario $actual, Usuario $recurso): bool
    {
        return $recurso->id == $actual->id;
    }

    public function borrarAvatar(Usuario $actual, Usuario $recurso): bool
    {
        return $recurso->id == $actual->id;
    }
}
