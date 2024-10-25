<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre', 'usuario_id', 'paquete_id', 'paquete_precio', 'precio',
        'fecha', 'hora_inicio', 'hora_fin', 'descripcion', 'gerente_id',
        'num_personas', 'confirmacion', 'realizado', 'motivo',
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

    public function dueño(){
        return $this->hasOne(Usuario::class, "id","usuario_id");
    }

    public function gerente(){
        return $this->hasOne(Usuario::class, "id","gerente_id")
//        ->withDefault();
        ->withDefault(["nombre"=>"Sin gerente que haya revisado"]);

    }
}
