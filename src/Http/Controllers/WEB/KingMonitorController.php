<?php

namespace ByCarmona141\KingMonitor\Http\Controllers\WEB;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ByCarmona141\KingMonitor\Facades\KingMonitor;

//use ByCarmona141\KingMonitor\Models\KingMonitor;

class KingMonitorController extends Controller {
    public function index(Request $request) {
        // Obtenemos las estadisticas del monitor
        $statistics = KingMonitor::statistics();
        $historical = KingMonitor::historical();
        $statisticsExceeded = KingMonitor::statisticsExceeded();
        $historicalExceeded = KingMonitor::historicalExceeded();
        $statisticsAlert = KingMonitor::statisticsAlertTotal();
        $historicalAlert = KingMonitor::historicalAlertTotal();

        // Convertimos el json en arreglo
        $statistics = $statistics->original;
        $historical = $historical->original;
        $statisticsExceeded = $statisticsExceeded->original;
        $historicalExceeded = $historicalExceeded->original;
        $statisticsAlert = $statisticsAlert->original;
        $historicalAlert = $historicalAlert->original;

        // Mandamos los datos a la vista
        return view('king-monitor::monitor')
            ->with('statistics', $statistics)
            ->with('historical', $historical)
            ->with('statisticsExceeded', $statisticsExceeded)
            ->with('historicalExceeded', $historicalExceeded)
            ->with('statisticsAlert', $statisticsAlert)
            ->with('historicalAlert', $historicalAlert);
    }

    public function show($king_user_id) {
        // Obtenemos las estadisticas del monitor
        $statistics = KingMonitor::userStatistics($king_user_id);
        $historical = KingMonitor::userHistorical($king_user_id);
        $statisticsExceeded = KingMonitor::userStatisticsExceeded($king_user_id);
        $historicalExceeded = KingMonitor::userHistoricalExceeded($king_user_id);
        $statisticsAlert = KingMonitor::userStatisticsAlertTotal($king_user_id);
        $historicalAlert = KingMonitor::userHistoricalAlertTotal($king_user_id);

//        dd(gettype($historicalExceeded));

        // Convertimos el json en arreglo
        $statistics = $statistics->original;
        $historical = $historical->original;
        $statisticsExceeded = $statisticsExceeded->original;
        $historicalExceeded = $historicalExceeded->original;
        $statisticsAlert = $statisticsAlert->original;
        $historicalAlert = $historicalAlert->original;


        // Mandamos los datos a la vista
        return view('king-monitor::user')
            ->with('statistics', $statistics)
            ->with('historical', $historical)
            ->with('statisticsExceeded', $statisticsExceeded)
            ->with('historicalExceeded', $historicalExceeded)
            ->with('statisticsAlert', $statisticsAlert)
            ->with('historicalAlert', $historicalAlert);
    }
}
