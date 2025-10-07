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
        Schema::table('computadores', function (Blueprint $table) {

            $table->unsignedBigInteger('categoria_id')->nullable()->after('id');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');

            $table->string('codigo_barras')->nullable()->after('precio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('computadores', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
            $table->dropColumn(['categoria_id', 'codigo_barras']);
        });
    }
};
