<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Publica;
use App\Models\Usable;
use Illuminate\Http\Request;

class EventoPublicaControllerimagenes extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Evento $evento)
    {
        $fotos = Publica::whereIn('id',Usable::wehere('ofece_type','Evento')->pluck('ofrece_id'))->get();
        return response()->json($fotos);
//        return Publica::whereNotIn('id', Usable::pluck('ofrece_id'))->get();
    }

    /**
      * Show the form for creating a new resource.
     */
    public function create(Evento $evento)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Evento $evento)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Evento $evento, Publica $publica)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evento $evento, Publica $publica)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evento $evento, Publica $publica)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evento $evento, Publica $publica)
    {
        //
    }
}
