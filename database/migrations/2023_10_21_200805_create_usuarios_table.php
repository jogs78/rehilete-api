<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('nombre_usuario')->unique();
            $table->string('contraseña');
            $table->enum('rol', ['Gerente', 'Cliente', 'Empleado'])->default('Cliente');
            $table->string('token')->nullable();
            $table->bigInteger('expiracion', false, true)->nullable()->default(null);
            //$table->string('direccion')->nullable();
            $table->date('fecha_nacimiento');
            $table->string('email');
            $table->string('telefono')->nullable();
            $table->string('avatar')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
