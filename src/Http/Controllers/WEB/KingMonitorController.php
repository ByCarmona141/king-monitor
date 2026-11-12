<?php

namespace ByCarmona141\KingMonitor\Http\Controllers\WEB;

use Illuminate\Routing\Controller;
use ByCarmona141\KingMonitor\Facades\KingMonitor;
use ByCarmona141\KingMonitor\Services\StatisticsService;

//use ByCarmona141\KingMonitor\Models\KingMonitor;

class KingMonitorController extends Controller {
    /**
     * Recopila los datos comunes que se usan en todas las vistas del monitor.
     */
    private function getAlertData(): array {
        return [
            'statisticsAlert'  => KingMonitor::statisticsAlertTotal(),
            'historicalAlert'  => KingMonitor::historicalAlertTotal(),
        ];
    }

    /**
     * Vista principal del monitor (peticiones + errores combinados).
     */
    public function index() {
        // return KingMonitor::historicalExceeded();

        $data = array_merge([
            'statistics'          => KingMonitor::statistics(),
            'historical'          => KingMonitor::historical(),
            'statisticsExceeded'  => KingMonitor::statisticsExceeded(),
            'historicalExceeded'  => KingMonitor::historicalExceeded(),
        ], $this->getAlertData());



        return view('king-monitor::monitor', $data);
    }

    /**
     * Vista de errores del monitor.
     */
    public function errors() {
        $data = array_merge([
            'errorStatistics'          => KingMonitor::errorStatistics(),
            'errorHistorical'          => KingMonitor::errorHistorical(),
            'errorStatisticsExceeded'  => KingMonitor::errorStatisticsExceeded(),
            'errorHistoricalExceeded'  => KingMonitor::errorHistoricalExceeded(),
        ], $this->getAlertData());

        return view('king-monitor::monitor_errors', $data);
    }

    /**
     * Vista de peticiones del monitor.
     */
    public function requests() {
        $data = array_merge([
            'requestStatistics'          => KingMonitor::requestStatistics(),
            'requestHistorical'          => KingMonitor::requestHistorical(),
            'requestStatisticsExceeded'  => KingMonitor::requestStatisticsExceeded(),
            'requestHistoricalExceeded'  => KingMonitor::requestHistoricalExceeded(),
        ], $this->getAlertData());

        return view('king-monitor::monitor_requests', $data);
    }

    /**
     * Vista de un usuario específico.
     */
    public function show(int $king_user_id) {
        $data = $this->getUserData($king_user_id);

        return view('king-monitor::user', $data);
    }

    /**
     * Vista detallada de un usuario específico.
     */
    public function show_detailed(int $king_user_id) {
        $data = $this->getUserData($king_user_id);

        return view('king-monitor::user_detailed', $data);
    }

    /**
     * Recopila todos los datos relacionados con un usuario específico.
     */
    private function getUserData(int $king_user_id): array {
        return [
            'statistics'          => KingMonitor::userStatistics($king_user_id),
            'historical'          => KingMonitor::userHistorical($king_user_id),
            'statisticsExceeded'  => KingMonitor::userStatisticsExceeded($king_user_id),
            'historicalExceeded'  => KingMonitor::userHistoricalExceeded($king_user_id),
            'statisticsAlert'     => KingMonitor::userStatisticsAlertTotal($king_user_id),
            'historicalAlert'     => KingMonitor::userHistoricalAlertTotal($king_user_id),
        ];
    }

}
