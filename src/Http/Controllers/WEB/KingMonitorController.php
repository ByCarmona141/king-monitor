<?php

namespace ByCarmona141\KingMonitor\Http\Controllers\WEB;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use ByCarmona141\KingMonitor\Facades\KingMonitor;

//use ByCarmona141\KingMonitor\Models\KingMonitor;

class KingMonitorController extends Controller {
    public function index() {
        return view('king-monitor::monitor');
    }
//    public function index(Request $request) {
//        // Obtenemos las estadisticas del monitor
//        $kingMonitor = new KingMonitor();
//        $statistics = $kingMonitor->statistics();
//        $historical = $kingMonitor->historical();
//
//        // Convertimos el json en arreglo
//        $statistics = $statistics->original;
//        $historical = $historical->original;
//
//        // Mandamos los datos a la vista
//        return view('king.king-monitor')->with('statistics', $statistics)->with('historical', $historical);
//    }
//
//    public function show($king_user_id) {
//        // Obtenemos las estadisticas del monitor
//        $kingMonitor = new KingMonitor();
//        $statistics = $kingMonitor->statisticsUser($king_user_id);
//        $historical = $kingMonitor->userHistorical($king_user_id);
//
//        // Convertimos el json en arreglo
//        $statistics = $statistics->original;
//        $historical = $historical->original;
//
//        // Mandamos los datos a la vista
//        return view('king.user')->with('statistics', $statistics)->with('historical', $historical);
//    }
}
