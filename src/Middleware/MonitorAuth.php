<?php

namespace ByCarmona141\KingMonitor\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use ByCarmona141\KingMonitor\KingMonitor;
use ByCarmona141\KingMonitor\Models\KingMonitorAlert;
use ByCarmona141\KingMonitor\Http\Controllers\API\KingMonitorMailController;


class MonitorAuth {
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response {
        // Si el usuario no esta autenticado
        if (auth('api')->check() === false) {
            // Mandar una alerta al encargado
            $mailController = new KingMonitorMailController();
            $mailController->sendAlertUnauthenticated();

            // Guardamos la alerta
            $king_monitor_alert = new KingMonitorAlert();

            $king_monitor_alert->king_user_id = auth()->id();
            $king_monitor_alert->token = (request()->header() === NULL) ? NULL : request()->bearerToken();
            $king_monitor_alert->ip = request()->getClientIp(); // Crypt::encryptString($request->getClientIp());
            $king_monitor_alert->save();

            // Guardamos el error
            $king_monitor = new KingMonitor();

            $king_monitor->monitorErrorUnauthenticated(NULL, 'Unauthenticated');
        }

        return $next($request);
    }
}