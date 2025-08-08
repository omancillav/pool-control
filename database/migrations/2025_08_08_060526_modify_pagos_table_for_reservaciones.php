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
            // Agregar campos nuevos para el sistema de reservaciones
            $table->unsignedBigInteger('id_reservacion')->nullable()->after('id_clase');
            $table->enum('metodo_pago', ['online', 'fisico'])->default('online')->after('fecha');
            $table->enum('estado', ['pendiente', 'completado', 'cancelado'])->default('pendiente')->after('metodo_pago');
            $table->string('numero_transaccion')->nullable()->after('estado');
            $table->text('notas')->nullable()->after('numero_transaccion');

            // Hacer id_membresia nullable (para pagos de reservaciones que no requieren membresía)
            $table->unsignedBigInteger('id_membresia')->nullable()->change();
            $table->unsignedBigInteger('id_clase')->nullable()->change();

            // Agregar foreign key para reservaciones
            $table->foreign('id_reservacion')->references('id')->on('reservaciones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            // Eliminar foreign key
            $table->dropForeign(['id_reservacion']);
            
            // Eliminar columnas agregadas
            $table->dropColumn([
                'id_reservacion',
                'metodo_pago',
                'estado',
                'numero_transaccion',
                'notas'
            ]);

            // Revertir cambios de nullable (esto podría fallar si hay datos)
            // $table->unsignedBigInteger('id_membresia')->nullable(false)->change();
            // $table->unsignedBigInteger('id_clase')->nullable(false)->change();
        });
    }
};
