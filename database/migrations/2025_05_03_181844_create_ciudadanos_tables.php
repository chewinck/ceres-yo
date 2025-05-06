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
        
            $table->unsignedBigInteger('id')->primary();
            $table->string('nacionalidad');
            $table->enum('tipo_identificacion'.['CC','CE','PA','DE','PEP','PPT'])->default('CC');
            $table->string('numero_identificacion',20)->unique();
            $table->date('fecha_expedicion');
            $table->string('telefono',15);
            $table->string('tipo_direccion',15);
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
