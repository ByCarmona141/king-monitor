<?php

namespace ByCarmona141\KingMonitor\Models;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KingMonitorAverage extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'king_type_average_id',
        'king_time_id',
        'initial_period',
        'final_period',
        'average',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function kingDestroy(KingMonitorAverage $kingMonitorAverage): Response {
        // Eliminar registro en la base de datos
        $kingMonitorAverage->delete();
        $response = response()->noContent();

        // Guardamos la accion en el monitor
        $kingMonitor = new KingMonitor();
        $kingMonitor->monitor($response, $kingMonitorAverage->id, TRUE);

        return $response;
    }


    public function statistics() {

    }

    public function averageMonitor() {
        // Obtenemos la cantidad de errores del día
        $count = KingMonitor::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();

        return $count;
    }
}
