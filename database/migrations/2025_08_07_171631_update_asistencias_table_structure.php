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
        Schema::table('asistencias', function (Blueprint $table) {
            // Eliminamos campos redundantes ya que la información se puede obtener de las relaciones
            $table->dropForeign(['id_profesor']);
            $table->dropForeign(['id_membresia']);
            $table->dropColumn(['id_profesor', 'id_membresia']);
            
            // Agregamos campos útiles para asistencias
            $table->boolean('presente')->default(true); // true = presente, false = ausente
            $table->text('observaciones')->nullable(); // Notas sobre la asistencia
            $table->timestamp('fecha_marcado')->useCurrent(); // Cuándo se marcó la asistencia
            
            // Evitar asistencias duplicadas
            $table->unique(['id_clase', 'id_usuario']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asistencias', function (Blueprint $table) {
            $table->dropUnique(['id_clase', 'id_usuario']);
            $table->dropColumn(['presente', 'observaciones', 'fecha_marcado']);
            $table->unsignedBigInteger('id_profesor')->nullable();
            $table->unsignedBigInteger('id_membresia')->nullable();
            $table->foreign('id_profesor')->references('id')->on('users');
            $table->foreign('id_membresia')->references('id')->on('membresias');
        });
    }
};
