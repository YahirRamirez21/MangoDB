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
        Schema::create('hectareas', function (Blueprint $table) {
            $table->id();
            $table->decimal('renta', 10, 2)->nullable();
            $table->decimal('porcentaje_general', 5, 2)->nullable();
            $table->date('fecha_recoleccion')->nullable();
            $table->unsignedBigInteger('id_jefe_cuadrilla');

            
            $table->foreign('id_jefe_cuadrilla')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hectareas');
    }
};
