<?php

namespace ByCarmona141\KingMonitor\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

use ByCarmona141\KingMonitor\Models\KingMonitor;
use ByCarmona141\KingMonitor\Models\KingMonitorError;
use ByCarmona141\KingMonitor\Models\KingMonitorAverage;

class KingMonitorCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'king-monitor:average {time=week}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Saves the average of errors and successful requests';

    /**
     * Execute the console command.
     */
    public function handle() {
        // Obtenemos el parametro que fue enviado en el comando
        $time = $this->argument('time');

        switch ($time) {
            case 'day':
                // Obtenemos la cantidad de peticiones satisfactorias del día
                $countSuccessful = KingMonitor::whereDate('created_at', '=', now())->count();

                // Obtenemos la cantidad de errores del día
                $countErrors = KingMonitorError::whereDate('created_at', '=', now())->count();

                // Guardamos en la tabla KingMonitorAverage
                $kingMonitorAverage1 = new KingMonitorAverage();
                $kingMonitorAverage2 = new KingMonitorAverage();

                // Guardamos el Successful
                $kingMonitorAverage1->king_type_average_id = 1;
                $kingMonitorAverage1->king_time_id = 1;
                $kingMonitorAverage1->initial_period = now();
                $kingMonitorAverage1->final_period = now();
                $kingMonitorAverage1->average = $countSuccessful;

                $kingMonitorAverage1->save();

                // Guardamos los errors
                $kingMonitorAverage2->king_type_average_id = 2;
                $kingMonitorAverage2->king_time_id = 1;
                $kingMonitorAverage2->initial_period = now();
                $kingMonitorAverage2->final_period = now();
                $kingMonitorAverage2->average = $countErrors;

                $kingMonitorAverage2->save();
                break;
            case 'week':
                // Obtenemos la cantidad de peticiones satisfactorias de la semana
                $countSuccessful = KingMonitor::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count();

                // Obtenemos la cantidad de errores de la semana
                $countErrors = KingMonitorError::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count();

                // Guardamos en la tabla KingMonitorAverage
                $kingMonitorAverage1 = new KingMonitorAverage();
                $kingMonitorAverage2 = new KingMonitorAverage();

                // Guardamos el Successful
                $kingMonitorAverage1->king_type_average_id = 1;
                $kingMonitorAverage1->king_time_id = 2;
                $kingMonitorAverage1->initial_period = Carbon::now()->startOfWeek();
                $kingMonitorAverage1->final_period = Carbon::now()->endOfWeek();
                $kingMonitorAverage1->average = $countSuccessful;

                $kingMonitorAverage1->save();

                // Guardamos los errors
                $kingMonitorAverage2->king_type_average_id = 2;
                $kingMonitorAverage2->king_time_id = 2;
                $kingMonitorAverage2->initial_period = Carbon::now()->startOfWeek();
                $kingMonitorAverage2->final_period = Carbon::now()->endOfWeek();
                $kingMonitorAverage2->average = $countErrors;

                $kingMonitorAverage2->save();
                break;
            case 'month':
                // Obtenemos la cantidad de peticiones satisfactorias del mes
                $countSuccessful = KingMonitor::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count();

                // Obtenemos la cantidad de errores del mes
                $countErrors = KingMonitorError::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count();

                // Guardamos en la tabla KingMonitorAverage
                $kingMonitorAverage1 = new KingMonitorAverage();
                $kingMonitorAverage2 = new KingMonitorAverage();

                // Guardamos el Successful
                $kingMonitorAverage1->king_type_average_id = 1;
                $kingMonitorAverage1->king_time_id = 3;
                $kingMonitorAverage1->initial_period = now();
                $kingMonitorAverage1->final_period = now();
                $kingMonitorAverage1->average = $countSuccessful;

                $kingMonitorAverage1->save();

                // Guardamos los errors
                $kingMonitorAverage2->king_type_average_id = 2;
                $kingMonitorAverage2->king_time_id = 3;
                $kingMonitorAverage2->initial_period = now();
                $kingMonitorAverage2->final_period = now();
                $kingMonitorAverage2->average = $countErrors;

                $kingMonitorAverage2->save();
                break;
            case 'quarter':
                // Obtenemos la cantidad de peticiones satisfactorias del trimestre
                $countSuccessful = KingMonitor::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->count();

                // Obtenemos la cantidad de errores del trimestre
                $countErrors = KingMonitorError::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->count();

                // Guardamos en la tabla KingMonitorAverage
                $kingMonitorAverage1 = new KingMonitorAverage();
                $kingMonitorAverage2 = new KingMonitorAverage();

                // Guardamos el Successful
                $kingMonitorAverage1->king_type_average_id = 1;
                $kingMonitorAverage1->king_time_id = 4;
                $kingMonitorAverage1->initial_period = Carbon::now()->startOfQuarter();
                $kingMonitorAverage1->final_period = Carbon::now()->endOfQuarter();
                $kingMonitorAverage1->average = $countSuccessful;

                $kingMonitorAverage1->save();

                // Guardamos los errors
                $kingMonitorAverage2->king_type_average_id = 2;
                $kingMonitorAverage2->king_time_id = 4;
                $kingMonitorAverage2->initial_period = Carbon::now()->startOfQuarter();
                $kingMonitorAverage2->final_period = Carbon::now()->endOfQuarter();
                $kingMonitorAverage2->average = $countErrors;

                $kingMonitorAverage2->save();
                break;
            case 'year':
                // Obtenemos la cantidad de peticiones satisfactorias del año
                $countSuccessful = KingMonitor::whereYear('created_at', '=', now())->count();

                // Obtenemos la cantidad de errores del año
                $countErrors = KingMonitorError::whereYear('created_at', '=', now())->count();

                // Guardamos en la tabla KingMonitorAverage
                $kingMonitorAverage1 = new KingMonitorAverage();
                $kingMonitorAverage2 = new KingMonitorAverage();

                // Guardamos el Successful
                $kingMonitorAverage1->king_type_average_id = 1;
                $kingMonitorAverage1->king_time_id = 5;
                $kingMonitorAverage1->initial_period = now();
                $kingMonitorAverage1->final_period = now();
                $kingMonitorAverage1->average = $countSuccessful;

                $kingMonitorAverage1->save();

                // Guardamos los errors
                $kingMonitorAverage2->king_type_average_id = 2;
                $kingMonitorAverage2->king_time_id = 5;
                $kingMonitorAverage2->initial_period = now();
                $kingMonitorAverage2->final_period = now();
                $kingMonitorAverage2->average = $countErrors;

                $kingMonitorAverage2->save();
                break;
            default:
                # code...
                break;
        }

        $this->info("Saved Data: $time");
        return Command::SUCCESS;
    }
}
