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
        Schema::create('cajas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_hectarea');
            $table->decimal('kilogramos', 10, 2);
            $table->string('calidad', 50)->nullable();
            $table->date('fecha_cosecha');
            $table->date('fecha_ingreso_almacen')->nullable();
            $table->foreign('id_hectarea')->references('id')->on('hectareas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cajas');
    }
};
