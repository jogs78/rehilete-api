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
        $ret = ($user->rol == 'Gerente') || ($user->rol == 'Empleado' && $evento->estado == 'validado') || ($user->rol == 'Cliente' && $evento->usuario_id == $user->id);
        Log::channel('debug')->info("Puede ver un evento: $ret");

        return $ret;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Usuario $user): bool
    {
        Log::channel('debug')->info("El rol del que quiere agregar evento es : $user->rol");
        $ret = ! ($user->rol == 'Empleado');
        Log::channel('debug')->info("Puede crear un evento: $ret");

        return $ret;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Usuario $user, Evento $evento): bool
    {
        $ret = ($evento->estado == 'sin validar' && ($user->rol == 'Gerente' || ($user->rol == 'Cliente' && $evento->usuario_id == $user->id)));
        Log::channel('debug')->info("Puede actualizar  un evento: $ret");

        return $ret;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Usuario $user, Evento $evento): bool
    {
        /*
                $ret =  ($user->rol='Gerente' && (($evento->estado == 'sin validar' || $evento->estado == 'rechazado' )) )
                    ||  ($user->rol='Cliente' && (($evento->estado == 'sin validar' || $evento->estado == 'rechazado' )) );
        */
        Log::channel('debug')->info("Puede borrar un evento un $user->rol");
        $ret = ($evento->estado == 'sin validar' || $evento->estado == 'rechazado') && ($user->rol == 'Gerente' || ($user->rol == 'Cliente' && $evento->usuario_id == $user->id));
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
        /**
     * Determine whether the user can view the model.
     */
    public function contrato (Usuario $usuario, Evento $evento): bool
    {
        return $usuario->rol == 'Gerente' || ( $usuario->rol == 'Cliente' && $usuario->id == $evento->usuario_id);
    }

}
