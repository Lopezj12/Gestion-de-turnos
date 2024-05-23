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
        Schema::create('turnos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_paciente')->constrained('pacientes');
            $table->foreignId('id_servicio')->constrained('servicios');
            $table->dateTime('hora_asignacion');
            $table->enum('estado', ['Pendiente', 'Completado', 'Cancelado'])->default('Pendiente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turnos');
    }
};
