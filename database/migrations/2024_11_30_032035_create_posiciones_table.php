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
        Schema::create('posiciones', function (Blueprint $table) {
            $table->integer('estante');
            $table->integer('division');
            $table->integer('subdivision');
            $table->unsignedBigInteger('id_caja')->nullable();
            $table->unsignedBigInteger('id_almacen');
            $table->primary(['estante', 'division', 'subdivision', 'id_almacen']); 
            $table->foreign('id_caja')->references('id')->on('cajas');
            $table->foreign('id_almacen')->references('id')->on('almacenes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posiciones');
    }
};
