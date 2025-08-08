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
        Schema::table('pagos', function (Blueprint $table) {
            // Eliminar foreign keys primero
            $table->dropForeign(['id_clase']);
            $table->dropForeign(['id_reservacion']);
            
            // Eliminar las columnas relacionadas con clases individuales y reservaciones
            $table->dropColumn(['id_clase', 'id_reservacion']);
            
            // Hacer id_membresia obligatorio nuevamente (solo para pagos de membresías)
            $table->unsignedBigInteger('id_membresia')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            // Restaurar las columnas
            $table->unsignedBigInteger('id_clase')->nullable()->after('id_membresia');
            $table->unsignedBigInteger('id_reservacion')->nullable()->after('id_clase');
            
            // Restaurar foreign keys
            $table->foreign('id_clase')->references('id')->on('clases')->onDelete('cascade');
            $table->foreign('id_reservacion')->references('id')->on('reservaciones')->onDelete('cascade');
            
            // Hacer id_membresia nullable
            $table->unsignedBigInteger('id_membresia')->nullable()->change();
        });
    }
};
