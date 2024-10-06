<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Servicio extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nombre', 'precio', 'descripcion', 'minimo', ];

    public function paquetes() {
        return $this->belongsToMany(Paquete::class);
    }
    public function eventos()
    {
        return $this->belongsToMany(Evento::class);
    }

    public function imagenes(): MorphToMany
    {
        return $this->morphToMany(Medio::class, 'usa','usables',);
    }

    /*
    public function imagenes(): MorphToMany
    {
        return $this->morphToMany(Publica::class, 'oferta', 'usables', 'oferta_id','oferta_type','oferta_id','id','relacion','inversa');
    }
    */
}
