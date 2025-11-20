<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pqr;
use Carbon\Carbon;

class ActualizarEstadosPqrs extends Command
{
    protected $signature = 'pqr:actualizar-estados';
    protected $description = 'Actualiza el estado de las PQR según la antigüedad';

    public function handle()
    {
        $ahora = Carbon::now();

        // A 24 horas -> estado 2
        Pqr::where('id_estado', 1)
            ->where('created_at', '<=', $ahora->copy()->subHours(24))
            ->update(['id_estado' => 2]);

        // A 48 horas -> estado 3
        Pqr::where('id_estado', 2)
            ->where('created_at', '<=', $ahora->copy()->subHours(48))
            ->update(['id_estado' => 3]);

        $this->info("Estados actualizados correctamente.");
    }
}
