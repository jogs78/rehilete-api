<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
    use HasFactory;

    public function quienRecibio()
    {
        return $this->belognsTo(Usuario::class, 'id', 'quien_recibio');
    }
    public function evento(){
        return $this->belongsTo(Evento::class);
    }
}
