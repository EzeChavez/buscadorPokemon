<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

     //Creación de la tabla para guardar el historial de busqueda
    public function up(): void
    {
        Schema::create('historial_busquedas', function (Blueprint $table) {
            $table->id();
            $table->string('termino_busqueda');
            $table->json('resultado');
            $table->string('id_sesion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_busquedas');
    }
};
