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
        Schema::create('ciudadanos', function (Blueprint $table) {
        
            $table->unsignedBigInteger('id')->primary();
            $table->enum('nacionalidad',['Colombiana','Extranjera']);
            $table->enum('tipo_identificacion',['CC','CE','PA','DE','RC','TI','PEP','PPT'])->default('CC');
            $table->string('numero_identificacion',20)->unique();
            $table->date('fecha_expedicion');
            $table->string('telefono',15);
            $table->enum('tipo_direccion',['Rural','Urbana'])->default('Urbana');
            $table->string('barrio',50);
            $table->string('direccion', 50);
            $table->timestamps();

            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
            
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
