<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;
    protected $fillable = [
        'realizado', // Agrega cualquier otro campo que desees incluir aquí
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function paquete()
    {
        return $this->belongsTo(Paquete::class);
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class);
    }

    public function fotos(){
        return $this->hasMany(Foto::class);
    }
}
