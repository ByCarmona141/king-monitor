<?php

namespace ByCarmona141\KingMonitor\Middleware;

use ByCarmona141\KingMonitor\Http\Controllers\API\KingMonitorMailController;
use ByCarmona141\KingMonitor\Models\KingMonitorAlert;
use ByCarmona141\KingMonitor\Models\KingMonitorUserExceeded;
use Closure;
use Illuminate\Http\Request;
use ByCarmona141\KingMonitor\Facades\KingMonitor;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;


class KingMonitorMiddleware {
    /**
     * Intercepta la petición y la respuesta automáticamente.
     */
    public function handle(Request $request, Closure $next)
    {
        // procesa la petición y genera una respuesta
        $response = $next($request);

        return $response;
    }
}