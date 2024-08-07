<?php

namespace ByCarmona141\KingMonitor\Http\Controllers\API;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use ByCarmona141\KingMonitor\Models\KingMonitorAverage;

class KingMonitorAverageController extends Controller {
    public function averageMonitor() {
        $king = new KingMonitorAverage();
        return $king->averageMonitor();
    }
}
