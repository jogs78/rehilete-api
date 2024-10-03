<?php

namespace App\Policies;

use App\Models\Evento;
use App\Models\Usuario;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class EventoPolicy
{
    public function confirmar(Usuario $user, Evento $evento): bool
    {
        Log::channel('debug')->info("Usuario que rechzaa evento: " . $user->tojson());
        Log::channel('debug')->info("Evento: " . $evento->tojson());

        if ($user->rol == "Gerente") {
            return true;
        }
        return false;
    }
    public function rechazar(Usuario $user, Evento $evento): bool
    {
        Log::channel('debug')->info("Usuario que rechzaa evento: " . $user->tojson());
        Log::channel('debug')->info("Evento: " . $evento->tojson());

        if ($user ->rol == "Gerente") {
            return true;
        }
        return false;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Usuario $user): bool
    {
        Log::channel('debug')->info("Usuario que lista eventos: " . $user->tojson());
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Usuario $user, Evento $evento): bool
    {
        Log::channel('debug')->info("Usuario: " . $user->tojson());
        Log::channel('debug')->info(" ver Evento: " . $evento->tojson());
        switch ($user->rol) {
            case 'Gerente':
                return true;
            break;

            case 'Empleado':
                if($evento->confirmacion == 'confirmado') {
                    return true;
                }else return false;
            break;

            case 'Cliente':
                if($evento->usuario_id == $user->id) {
                    return true;
                }else return false;
            break;

            default:
                return false;
                Log::channel('debug')->info("return false");
            break;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Usuario $user): bool
    {
        Log::channel('debug')->info("Usuario que creea eventos: " . $user->tojson());
        switch ($user->rol) {
            case 'Gerente':
                return true;
            break;

            case 'Empleado':
                return false;
            break;

            case 'Cliente':
                return true;
            break;

            default:
                return false;
            break;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Usuario $user, Evento $evento): bool
    {
        Log::channel('debug')->info("Usuario: " . $user->tojson());
        Log::channel('debug')->info("editar Evento: " . $evento->tojson());
        switch ($user->rol) {
            case 'Gerente':
                if($evento->confirmacion == 'sin confirmar' ) {
                    return true;
                }
                return false;
            break;
            case 'Empleado':
                return false;
            break;
            case 'Cliente':
                if($evento->confirmacion == 'sin confirmar' ) {
                    return true;
                }
                return false;
            break;
            default:
                return false;
                Log::channel('debug')->info("return false");
            break;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Usuario $user, Evento $evento): bool
    {
        Log::channel('debug')->info("Usuario: " . $user->tojson());
        Log::channel('debug')->info("editar Evento: " . $evento->tojson());
        switch ($user->rol) {
            case 'Gerente':
                if($evento->confirmacion == 'sin confirmar' || $evento->confirmacion == 'rechazado' ) {
                    return true;
                }
                return false;
            break;
            case 'Empleado':
                return false;
            break;
            case 'Cliente':
                if($evento->confirmacion == 'sin confirmar' || $evento->confirmacion == 'rechazado' ) {
                    return true;
                }
                return false;
            break;
            default:
                return false;
                Log::channel('debug')->info("return false");
            break;
        }
        //if($evento->confirmacion == 0) return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Usuario $user, Evento $evento): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Usuario $user, Evento $evento): bool
    {
        return true;
    }

}
