<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Medio extends Model
{
    use HasFactory;

    public function paquetes(): MorphToMany
    {
        return $this->morphedByMany(Paquete::class, 'b');
    }

    public function servicios(): MorphToMany
    {
        return $this->morphedByMany(Servicio::class, 'usable');
    }
}
