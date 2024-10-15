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

        if ($user->rol == "Gerente");
        
    }
    public function rechazar(Usuario $user, Evento $evento): bool
    {
        Log::channel('debug')->info("Usuario que rechzaa evento: " . $user->tojson());
        Log::channel('debug')->info("Evento: " . $evento->tojson());

        return ($user ->rol == "Gerente") ;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Usuario $user): bool
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
        return $user->rol == 'Gerente' || $user->rol =='Cliente' ;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Usuario $user, Evento $evento): bool
    {
        Log::channel('debug')->info("Usuario: " . $user->tojson());
        Log::channel('debug')->info("editar Evento: " . $evento->tojson());
        return $evento->confirmacion == 'sin confirmar'  && ($user->rol == 'Gerente' || $user->rol =='Cliente') ;
  
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Usuario $user, Evento $evento): bool
    {
        Log::channel('debug')->info("Usuario: " . $user->tojson());
        Log::channel('debug')->info("editar Evento: " . $evento->tojson());
        return ($evento->confirmacion == 'sin confirmar' || $evento->confirmacion == 'rechazado' )
                && ($user->rol == 'Gerente' || $user->rol =='Cliente') ;

    }


}
