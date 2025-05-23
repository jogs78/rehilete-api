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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('motivo');
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('paquete_id')->nullable();
            $table->float('paquete_precio')->nullable();
            $table->float('precio');
            $table->date('fecha'); //el formato es aaaa-mm-dd
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->string('descripcion');
            $table->integer('gerente_id')->nullable(); //para saver quien lo confirmó
            $table->integer('num_personas')->default(100);
            $table->enum('estado', ['sin validar', 'rechazado', 'validado','postergado'])->default('sin validar'); // SinConfirmar  || espera || Confirmado
            $table->boolean('realizado')->default(false);
            $table->string('razon')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->foreign('paquete_id')->references('id')->on('paquetes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
