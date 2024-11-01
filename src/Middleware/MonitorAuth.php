<?php

namespace ByCarmona141\KingMonitor\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use ByCarmona141\KingMonitor\KingMonitor;
use ByCarmona141\KingMonitor\Http\Controllers\API\KingMonitorMailController;


class MonitorAuth {
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response {
        // Si el usuario no esta autenticado
        if (auth()->user() === NULL) {
            // Mandar una alerta al encargado
            $mailController = new KingMonitorMailController();
            $mailController->sendAlertUnauthenticated();

            // Guardamos la alerta

            // Guardamos el error
            $king_monitor = new KingMonitor();

            $king_monitor->monitorError(NULL, 'Unauthenticated');
        }

        return $next($request);
    }
}