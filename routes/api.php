<?php

use App\Http\Controllers\AbonoController;
use App\Http\Controllers\AyudaController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\EventoFotoController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\PublicaController;
use App\Http\Controllers\PuertaController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\ServicioMedioController;
use App\Http\Controllers\PaqueteController;
use App\Http\Controllers\PaqueteMedioController;
use App\Http\Controllers\UsablePublicaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('entrada', [PuertaController::class, 'entrada']);
Route::post('salida', [PuertaController::class,'salida'])->middleware('conToken')->name('usuarios.avatar');


Route::apiResource('servicios', ServicioController::class, ['only'   => ['index']]);
Route::apiResource('servicios', ServicioController::class, ['except' => ['index']])->middleware('conToken');
Route::apiResource('servicios.medios', ServicioMedioController::class, ['only' => ['index']]);
Route::apiResource('servicios.medios', ServicioMedioController::class, ['except' => ['index','update']])->middleware('conToken');



Route::apiResource('usuarios', UsuarioController::class)->middleware('conToken'); //pero solo debe ser con cierto nivel de usuario, de eso se encarga UsuarioPolicy, pero creo no esta implementado
Route::post('usuarios/registrar', [AyudaController::class,'registroUsuario']); //no valida... la bd si, pero marca error 500, puede dar de alta varias veces al mismo
route::get('incializar', [AyudaController::class,'inicializar'])->middleware('conToken');
Route::get('usuarios/{usuario}/avatar', [UsuarioController::class,'avatar'])->middleware('conToken'); //no valida... la bd si, pero marca error 500, puede dar de alta varias veces al mismo
Route::post('usuarios/{usuario}/avatar', [UsuarioController::class,'avatar2'])->middleware('conToken'); //no valida... la bd si, pero marca error 500, puede dar de alta varias veces al mismo

Route::apiResource('paquetes', PaqueteController::class, ['only'   => ['index']]);
Route::apiResource('paquetes', PaqueteController::class, ['except' => ['index']])->middleware('conToken');
Route::apiResource('paquetes.medios', PaqueteMedioController::class, ['only' => ['index']]);
Route::apiResource('paquetes.medios', PaqueteMedioController::class, ['except' => ['index','update']])->middleware('conToken');

Route::apiResource('eventos', EventoController::class)->middleware('conToken');//
Route::put('eventos/{evento}/confirmar',[EventoController::class, 'confirmar'])->middleware('conToken');//
Route::put('eventos/{evento}/rechazar',[EventoController::class, 'rechazar'])->middleware('conToken');//
//estos deben ser nested tanto gastos como abonos
Route::put('actualizar/evento/{evento}', [EventoController::class,'actualizarEstatus'])->middleware('conToken');
Route::apiResource('gastos', GastoController::class)->middleware('conToken');
Route::apiResource('abonos',AbonoController::class)->middleware('conToken');

Route::apiResource('fotos', FotoController::class, ['only' => ['show']])->middleware('conToken');
Route::apiResource('evento.fotos', EventoFotoController::class,['except' => ['show', 'update']])->middleware('conToken');




//Route::get('publicas', [PublicaController::class,'index2'])->middleware('conToken');
Route::apiResource('publicas', PublicaController::class)->middleware('conToken');
Route::apiResource('usable.publicas', UsablePublicaController::class)->middleware('conToken');

//Route::get('ver/privada/{privada}',[PrivadaController::class,'show2'])->middleware('conToken');
//Route::get('ver/publica/{publica}',[PublicaController::class,'show2'])->middleware('conToken');