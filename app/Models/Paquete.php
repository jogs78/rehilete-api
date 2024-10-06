<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Http\Requests\StorePaqueteRequest;

class Paquete extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'activo', 'precio', 'descripcion', ];

    public function servicios() {
        return $this->belongsToMany(Servicio::class);
    }

    public function eventos() {
        return $this->hasMany(Evento::class);
    }

    public function imagenes(): MorphToMany
    {
        return $this->morphToMany(Medio::class, 'usa','usables');
    }

}
