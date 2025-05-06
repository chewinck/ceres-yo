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
        Schema::create('solicitudes_certificado', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('uuid', 50)->unique();
            $table->unsignedBigInteger('ciudadano_id');
            $table->string('tiempo_residencia', 30);
            $table->date('fecha_emision_certificado');
            $table->enum('tipo_solicitud',['automatica', 'exepcional'])->default('automatica');
            $table->enum('tipo_certificado', ['EVE','PPL','PEPA','TAPEP']);
            $table->enum('estado',['iniciada','rechazada','exitosa'])->default('pendiente');
            $table->string('requisito')->nullable();
            $table->string('plantilla_certificado', 80);
            $table->json('informacion_adicional');
            $table->timestamps();

            $table->foreign('ciudadano_id')->references('id')->on('ciudadanos')->onDelete('cascade');

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solciitudes_certificado');
    }
};
