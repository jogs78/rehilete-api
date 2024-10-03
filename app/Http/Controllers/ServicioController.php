<?php

namespace App\Http\Controllers;

use App\Models\Servicio;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicios = Servicio::all();
        return response()->json($servicios,200,['Content-Type'=> 'application/json']);

    }

    public function store(Request $request)
    {
        try {
            if (Auth::check()) {
                // El usuario está autenticado
                $this->authorize('create', Servicio::class);
            } else {
                // El usuario no está autenticado
                return response()->json(["error" => "Usuario no autenticado"], 401);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error en Asegurar Middleware: " . $e->getMessage());
            //$er = $e->getMessage();
            return response()->json(["errors" => "Error de servidor"], 500);
        }
        
        $servicio = new Servicio();
        $servicio->nombre = $request->nombre;
        $servicio->precio = $request->precio;
        $servicio->minimo = $request->minimo;
        $servicio->descripcion = $request->descripcion;
        $servicio->save();
        return response()->json(["success"=> "No hay errores"],200);
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        /*with('publicas','privadas')->*/
        $servicio = Servicio::find($id);
        return $servicio->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $servicio = Servicio::find($id);
        return view('gerente.servicios.editar-servicio', compact('servicio'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update', Servicio::find($id));
        $servicio = Servicio::find($id);

            $servicio->nombre = $request->nombre;
            $servicio->precio = $request->precio;
            $servicio->descripcion = $request->descripcion;
            $servicio->save();
            
        return $servicio->toJson();


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', Servicio::find($id));
        $servicio = Servicio::find($id);
        if ($servicio) {
            $servicio->delete();
            return response()->json(["success"=> "Servicio eliminado correctamente"],200);
        }else
        {
            return response()->json(["errors"=> "No se pudo eliminar el servicio"],400);
        }
        
    }
}
