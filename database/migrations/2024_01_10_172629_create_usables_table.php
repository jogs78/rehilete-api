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
        Schema::create('usables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medio_id');
            $table->unsignedBigInteger('usa_id')->nullable();
            $table->string('usa_type')->nullable();
            $table->timestamps();
            $table->unique(['medio_id', 'usa_id', 'usa_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usables');
    }
};
