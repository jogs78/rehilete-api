<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Paquete extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'activo', 'precio', 'descripcion'];

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class)->withPivot(['servicio_cantidad','servicio_precio'])->withTimestamps();
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }

    public function eventosConfirmados()
    {
        return $this->hasMany(Evento::class)->where('estado', 'validado');
    }

    public function eventosConfirmadosPendientes()
    {
        return $this->hasMany(Evento::class)
            ->where('estado', 'validado')
            ->where('realizado', false);
    }

    public function eventosNoConfirmados()
    {
        return $this->hasMany(Evento::class)->where('estado', 'sin validar');
    }

    public function imagenes(): MorphToMany
    {
        return $this->morphToMany(Medio::class, 'usa', 'usables')->withTimestamps();
    }
}
