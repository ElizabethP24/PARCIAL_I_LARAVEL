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
    Schema::create('ventas', function (Blueprint $table) {
    $table->id('codigo');

    // Datos del cliente
    $table->integer('documento_cliente');
    $table->string('nombre_cliente');

    // Relación con computador
    $table->unsignedBigInteger('computador');
    $table->foreign('computador')->on('computadores')->references('id')->onDelete('cascade');

    // Detalles de la venta
    $table->integer('cantidad');
    $table->decimal('precio', 12, 2);
    $table->date('fecha');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
