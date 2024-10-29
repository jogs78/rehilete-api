<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['nombre', 'apellido', 'nombre_usuario', 'contraseña',
        'rol', 'fecha_nacimiento', 'email', 'telefono'];

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }
}
