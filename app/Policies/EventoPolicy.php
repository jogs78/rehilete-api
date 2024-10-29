<?php

namespace App\Policies;

use App\Models\Evento;
use App\Models\Usuario;
use Illuminate\Support\Facades\Log;

class EventoPolicy
{
    public function confirmar(Usuario $user, Evento $evento): bool
    {
        $ret = ($user->rol == 'Gerente');
        Log::channel('debug')->info("Puede confirmar un evento: $ret");

        return $ret;
    }

    public function rechazar(Usuario $user, Evento $evento): bool
    {
        $ret = ($user->rol == 'Gerente');
        Log::channel('debug')->info("Puede rechazar un evento: $ret");

        return $ret;

    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Usuario $user): bool
    {
        $ret = true;
        Log::channel('debug')->info("Puede ver cualquier evento: $ret");

        return $ret;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Usuario $user, Evento $evento): bool
    {
        $ret = ($user->rol == 'Gerente') || ($user->rol == 'Empleado' && $evento->confirmacion == 'confirmado') || ($user->rol == 'Cliente' && $evento->usuario_id == $user->id);
        Log::channel('debug')->info("Puede ver un evento: $ret");

        return $ret;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Usuario $user): bool
    {
        $ret = ! ($user->rol == 'Empleado');
        Log::channel('debug')->info("Puede crear un evento: $ret");

        return $ret;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Usuario $user, Evento $evento): bool
    {
        $ret = ($evento->confirmacion == 'sin confirmar' && ($user->rol == 'Gerente' || ($user->rol == 'Cliente' && $evento->usuario_id == $user->id)));
        Log::channel('debug')->info("Puede actualizar  un evento: $ret");

        return $ret;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Usuario $user, Evento $evento): bool
    {
        /*
                $ret =  ($user->rol='Gerente' && (($evento->confirmacion == 'sin confirmar' || $evento->confirmacion == 'rechazado' )) )
                    ||  ($user->rol='Cliente' && (($evento->confirmacion == 'sin confirmar' || $evento->confirmacion == 'rechazado' )) );
        */
        $ret = ($evento->confirmacion == 'sin confirmar' || $evento->confirmacion == 'rechazado') && ($user->rol = 'Gerente' || $user->rol = 'Cliente');
        Log::channel('debug')->info("Puede borrar un evento: $ret");

        return $ret;
    }

    public function total(Usuario $user, Evento $evento): bool
    {
        if ($user->rol == 'Gerente' || $user->rol == 'Empleado') {
            return true;
        } else {
            // Puedes ahora usar $evento en la lógica de autorización
            return $user->id == $evento->user_id; // ejemplo de validación
        }

    }
}
