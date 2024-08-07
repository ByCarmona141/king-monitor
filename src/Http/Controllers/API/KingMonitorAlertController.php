<?php

namespace ByCarmona141\KingMonitor\Http\Controllers\API;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use ByCarmona141\KingMonitor\Models\KingMonitorAlert;

/**
 * @OA\Info(title="KingAPI", version="1.0")
 *
 * @OA\Server(url="http://localhost/api/v1")
 */

class KingMonitorAlertController extends Controller {
    /**
     * Obtiene la ultima alerta del usuario
     */
    public function lastAlertToday() {
        $king = new KingMonitorAlert();
        return $king->lastAlertToday();
    }

    /**
     * Obtiene las alertas del día
     */
    public function day(Request $request) {
        $king = new KingMonitorAlert();
        return $king->kingDay($request);
    }

    /**
     * Obtiene el contador de las alertas del día
     */
    public function dayCount(Request $request) {
        $king = new KingMonitorAlert();
        return $king->kingDayCount($request);
    }

    /**
     * Obtiene las alertas del mes
     */
    public function month(Request $request) {
        $king = new KingMonitorAlert();
        return $king->kingMonth($request);
    }

    /**
     * Obtiene las alertas del mes del año
     */
    public function monthYear(Request $request) {
        $king = new KingMonitorAlert();
        return $king->kingMonthYear($request);
    }
}
