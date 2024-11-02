<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Usuario;

class Foto extends Model
{
    use HasFactory;
    
    public function creadaPorCliente(){
        return Usuario::find($this->usuario_id)->rol == 'Cliente' ;
    }
}
