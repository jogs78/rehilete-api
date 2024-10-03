<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usable extends Model
{
    use HasFactory;
    protected $fillable = [
        'publica_id', 'usa_id', 'usa_type','created_at','updated_at'
    ] ;

}
