<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Movimiento;
use App\Models\MovimientoRecurrente;
use App\Services\MovimientoService;

class ProcesarMovimientosRecurrentes extends Command
{
    protected $signature = 'movimientos:recurrentes';

    protected $description = 'Procesa movimientos recurrentes';

    public function handle(MovimientoService $service): int
    {
        MovimientoRecurrente::query()
            ->with('user') // Cargar usuario para obtener su zona horaria
            ->where('activo', true)
            ->whereDate('proxima_fecha', '<=', today())
            ->each(function ($item) use ($service) {
                $user = $item->user;

                // Usar la zona horaria del usuario o la predeterminada
                $timezone = $user->timezone ?? config('app.timezone');
                $now = now($timezone)->startOfDay();

                // Solo procesar si la próxima fecha es menor o igual a hoy en la zona del usuario
                if (Carbon::parse($item->proxima_fecha)->lte($now)) {
                    $service->crear(
                        $item->user_id,
                        [
                            'cuenta_id' => $item->cuenta_id,
                            'categoria_id' => $item->categoria_id,
                            'tipo' => $item->tipo,
                            'fecha' => $item->proxima_fecha,
                            'descripcion' => $item->descripcion,
                            'monto' => $item->monto,
                        ]
                    );

                    $fecha = Carbon::parse($item->proxima_fecha);

                    switch ($item->frecuencia) {
                        case 'diaria':
                            $fecha->addDay();
                            break;
                        case 'semanal':
                            $fecha->addWeek();
                            break;
                        case 'mensual':
                            $fecha->addMonth();
                            break;
                        case 'anual':
                            $fecha->addYear();
                            break;
                    }

                    $item->update(['proxima_fecha' => $fecha]);
                }
            });

        return self::SUCCESS;
    }
}
