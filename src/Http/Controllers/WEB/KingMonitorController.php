<?php

namespace ByCarmona141\KingMonitor\Http\Controllers\WEB;

use ByCarmona141\KingMonitor\Facades\KingMonitor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

//use ByCarmona141\KingMonitor\Models\KingMonitor;

class KingMonitorController extends Controller {
    public function index(Request $request) {
        // Obtenemos las estadisticas del monitor
        $statistics = KingMonitor::statistics();
        $historical = KingMonitor::historical();

        // Convertimos el json en arreglo
        $statistics = $statistics->original;
        $historical = $historical->original;

        // Mandamos los datos a la vista
        return view('king-monitor::monitor')->with('statistics', $statistics)->with('historical', $historical);
    }

    public function show($king_user_id) {
        // Obtenemos las estadisticas del monitor
        $statistics = KingMonitor::userStatistics($king_user_id);
        $historical = KingMonitor::userHistorical($king_user_id);

        // Convertimos el json en arreglo
        $statistics = $statistics->original;
        $historical = $historical->original;

        // Mandamos los datos a la vista
        return view('king-monitor::user')->with('statistics', $statistics)->with('historical', $historical);
    }
}
