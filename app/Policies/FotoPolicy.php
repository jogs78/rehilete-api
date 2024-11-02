<?php

namespace App\Policies;

use App\Models\Evento;
use App\Models\Foto;
use App\Models\Usuario;

class FotoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Usuario $usuario, Evento $evento): bool
    {
        return $usuario->rol == 'Gerente' || ($usuario->rol == 'Empleado' && ($evento->realizado == true || $evento->enRangoHorario() == true) ) || ($usuario->rol == 'Cliente' && $evento->usuario_id == $usuario->id) ;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Usuario $usuario, Foto $foto, Evento $evento): bool
    {
        return $usuario->rol == 'Gerente' || ($usuario->rol == 'Empleado' && ($evento->realizado == true || $evento->enRangoHorario() == true) ) || ($usuario->rol == 'Cliente' && $evento->usuario_id == $usuario->id) ;

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Usuario $usuario, Evento $evento): bool
    {
        return $usuario->rol == 'Gerente' || ($usuario->rol == 'Empleado' && $evento->enRangoHorario() == true) || ($usuario->rol == 'Cliente' && $evento->usuario_id == $usuario->id) ;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Usuario $usuario, Foto $foto, Evento $evento): bool
    {
        return ($usuario->rol == 'Gerente' && $foto->creadaPorCliente() == false) || ($usuario->rol == 'Empleado' && $foto->usuario_id == $usuario->id) || ($usuario->rol == 'Cliente' && $foto->usuario_id == $usuario->id) ;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Usuario $usuario, Foto $foto): bool
    {
        return ($usuario->rol == 'Gerente' && $foto->creadaPorCliente() == false) || ($usuario->rol == 'Empleado' && $foto->usuario_id == $usuario->id) || ($usuario->rol == 'Cliente' && $foto->usuario_id == $usuario->id) ;
    }
}
