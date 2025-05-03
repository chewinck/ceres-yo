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
        Schema::create('ciudadanos_tables', function (Blueprint $table) {
            $table->id();
            $table->string('nacionalidad');
            $table->string('tipo_identificacion');
            $table->string('numero_identificacion');
            $table->string('fecha_expedicion');
            $table->string('telefono');
            $table->string('tipo_direccion');
            $table->string('barrio');
            $table->string('direccion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ciudadanos_tables');
    }
};
