<?php

use App\Http\Controllers\AyudaController;
use App\Http\Controllers\EventoAbonoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\EventoFotoController;
use App\Http\Controllers\EventoGastoController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\PaqueteController;
use App\Http\Controllers\PaqueteMedioController;
use App\Http\Controllers\PaqueteServicioController;
use App\Http\Controllers\PublicaController;
use App\Http\Controllers\PuertaController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\ServicioMedioController;
use App\Http\Controllers\UsablePublicaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('migrar', function () {
    echo 'Borrar:<br>';
    Artisan::call('db:wipe');
    echo 'Migrar<br>';
    Artisan::call('migrate',
        [
            '--seed' => true,
            '--force' => true,
        ]);
    return response()->json("OK");
});

Route::post('entrada', [PuertaController::class, 'entrada']);
Route::post('salida', [PuertaController::class, 'salida'])->middleware('conToken')->name('usuarios.avatar');

Route::apiResource('servicios', ServicioController::class, ['only' => ['index', 'show']])->middleware('sinToken');;
Route::apiResource('servicios', ServicioController::class, ['except' => ['index', 'show']])->middleware('conToken');
Route::apiResource('servicios.medios', ServicioMedioController::class, ['only' => ['index', 'show']]);
Route::apiResource('servicios.medios', ServicioMedioController::class, ['except' => ['index', 'show', 'update']])->middleware('conToken');

Route::apiResource('usuarios', UsuarioController::class)->middleware('conToken');
Route::post('usuarios/registrar', [AyudaController::class, 'registroUsuario']);
Route::get('usuarios/{usuario}/avatar', [UsuarioController::class, 'verAvatar'])->middleware('conToken');
Route::post('usuarios/{usuario}/avatar', [UsuarioController::class, 'subirAvatar'])->middleware('conToken');
Route::delete('usuarios/{usuario}/avatar', [UsuarioController::class, 'borrarAvatar'])->middleware('conToken');

route::get('incializar', [AyudaController::class, 'inicializar'])->middleware('conToken');

Route::apiResource('paquetes', PaqueteController::class, ['only' => ['index', 'show']])->middleware('sinToken');
Route::apiResource('paquetes', PaqueteController::class, ['except' => ['index', 'show']])->middleware('conToken');
Route::get('paquetes/tipo', [PaqueteController::class, 'tipo'])->middleware('conToken')->name('paquetes.activar');

Route::put('paquetes/activar/{paquete}', [PaqueteController::class, 'activar'])->middleware('conToken')->name('paquetes.activar');
Route::apiResource('paquetes.medios', PaqueteMedioController::class, ['only' => ['index', 'show']])->middleware('sinToken');
Route::apiResource('paquetes.medios', PaqueteMedioController::class, ['except' => ['index', 'update', 'show']])->middleware('conToken');
Route::apiResource('paquetes.servicios', PaqueteServicioController::class, ['except' => ['show', 'update']])->middleware('conToken');

Route::apiResource('eventos', EventoController::class)->middleware('conToken'); //
Route::get('eventos/{evento}/totalAbonos', [EventoController::class, 'totalAbonos'])->middleware('conToken');
Route::get('eventos/{evento}/totalGastos', [EventoController::class, 'totalGastos'])->middleware('conToken');
Route::put('eventos/{evento}/confirmar', [EventoController::class, 'confirmar'])->middleware('conToken'); //
Route::put('eventos/{evento}/rechazar', [EventoController::class, 'rechazar'])->middleware('conToken'); //
Route::get('eventos/{evento}/contrato', [EventoController::class, 'contrato'])->middleware('conToken'); //

Route::apiResource('eventos.abonos', EventoAbonoController::class, ['except' => ['update']])->middleware('conToken');
Route::apiResource('eventos.gastos', EventoGastoController::class, ['except' => ['show']])->middleware('conToken');

Route::apiResource('fotos', FotoController::class, ['only' => ['show']])->middleware('conToken');
Route::apiResource('eventos.fotos', EventoFotoController::class)->middleware('conToken');
Route::get('eventos/{evento}/fotos/{foto}/descripcion', [EventoFotoController::class,'descripcion'])->middleware('conToken');

Route::apiResource('publicas', PublicaController::class)->middleware('conToken');
Route::apiResource('usable.publicas', UsablePublicaController::class)->middleware('conToken');
