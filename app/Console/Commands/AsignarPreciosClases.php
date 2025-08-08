<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Clase;

class AsignarPreciosClases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clases:asignar-precios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Asignar precios a las clases existentes basado en su nivel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Asignando precios a las clases existentes...');

        // Obtener todas las clases sin precio o con precio 0
        $clases = Clase::where(function ($query) {
            $query->whereNull('precio')
                  ->orWhere('precio', 0);
        })->get();

        if ($clases->isEmpty()) {
            $this->info('No hay clases que requieran actualización de precios.');
            return;
        }

        $this->info("Se encontraron {$clases->count()} clases para actualizar.");

        $clasesActualizadas = 0;

        foreach ($clases as $clase) {
            $precioAnterior = $clase->precio;
            $clase->asignarPrecioPorNivel();
            $clase->save();

            $this->line("Clase ID {$clase->id} ({$clase->nivel}): {$precioAnterior} -> {$clase->precio}");
            $clasesActualizadas++;
        }

        $this->info("✅ Se actualizaron {$clasesActualizadas} clases exitosamente.");
    }
}
