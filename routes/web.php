<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
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
});

Route::get('politica',function () {
    echo "Politicas";
});
Route::get('condiciones',function () {
    echo "Condiciones";
});