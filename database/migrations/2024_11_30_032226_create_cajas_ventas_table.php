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
        Schema::create('cajas_ventas', function (Blueprint $table) {
            $table->id(); // id auto-incremental
            $table->unsignedBigInteger('id_caja');
            $table->unsignedBigInteger('id_venta');
            $table->foreign('id_caja')->references('id')->on('cajas');
            $table->foreign('id_venta')->references('id')->on('ventas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cajas_ventas');
    }
};
