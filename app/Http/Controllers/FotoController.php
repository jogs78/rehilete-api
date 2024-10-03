<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use Illuminate\Http\Request;

class FotoController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Foto $foto)
    {
        return response()->download(storage_path('app/privadas').'/'.$foto->ruta);
    }
}
