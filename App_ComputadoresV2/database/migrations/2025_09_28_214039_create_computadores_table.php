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
        Schema::create('computadores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('marca', 100)->nullable();
            $table->string('modelo', 100)->nullable();
            $table->string('procesador', 100)->nullable();
            $table->integer('ram_gb')->default(4);
            $table->integer('almacenamiento_gb')->nullable();
            $table->integer('cantidad')->default(0);
            $table->decimal('precio', 12, 2)->default(0);
            $table->string('imagen')->nullable();
            $table->boolean('portatil')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('computadores');
    }
};
