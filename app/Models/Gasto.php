<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    use HasFactory;
    public function eventos() //solo un registro
    {
        return $this->belongsTo(Evento::class);
    }
}
