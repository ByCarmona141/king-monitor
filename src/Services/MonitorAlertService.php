<?php
namespace ByCarmona141\KingMonitor\Services;

use ByCarmona141\KingMonitor\Models\KingMonitorAlert;
use ByCarmona141\KingMonitor\Models\KingMonitorUserExceeded;
use ByCarmona141\KingMonitor\Http\Controllers\API\KingMonitorMailController;

class MonitorAlertService
{
    /**
     * Manejar cuando se excede el límite
     */
    public function handleExceededLimit(string $type): void
    {
        $this->recordExceeded($type);

        $this->sendAlertIfNeeded($type);
    }

    /**
     * Enviar alerta para errores de autenticación
     */
    public function sendUnauthenticatedAlert(): void
    {
        $this->recordExceeded('error');

        // Enviar email directamente sin verificar tiempo
        $mailController = new KingMonitorMailController();
        $mailController->sendAlertUnauthenticated();

        // Registrar alerta
        KingMonitorAlert::create([
            'king_user_id' => auth()->id(),
            'token' => request()->bearerToken(),
            'ip' => request()->getClientIp(),
        ]);
    }

    private function recordExceeded(string $type): void
    {
        $typeId = $type === 'request' ? 1 : 2;

        // Verificar si ya existe un registro para hoy
        $exists = KingMonitorUserExceeded::whereDate('created_at', now()->toDateString())
            ->where('type', $typeId)
            ->where('king_user_id', auth()->id())
            ->where('token', request()->bearerToken())
            ->where('ip', request()->getClientIp())
            ->exists();

        if (!$exists) {
            $exceeded = new KingMonitorUserExceeded();
            $exceeded->type = $typeId;
            $exceeded->king_user_id = auth()->id();
            $exceeded->token = request()->bearerToken();
            $exceeded->ip = request()->getClientIp();
            $exceeded->save();
        }
    }

    private function sendAlertIfNeeded(string $type): void
    {
        $lastAlert = KingMonitorAlert::whereDate('created_at', now()->toDateString())
            ->where('king_user_id', auth()->id())
            ->latest()
            ->first();

        // Si no hay alerta o ya pasó el tiempo configurado
        if (!$lastAlert || $this->shouldSendNewAlert($lastAlert)) {
            // Enviar email
            $mailController = new KingMonitorMailController();
            $method = $type === 'request' ? 'sendAlertLimit' : 'sendAlertLimitError';
            $mailController->$method();

            // Registrar alerta
            KingMonitorAlert::create([
                'king_user_id' => auth()->id(),
                'token' => request()->bearerToken(),
                'ip' => request()->getClientIp(),
            ]);
        }
    }

    private function shouldSendNewAlert($lastAlert): bool
    {
        $secondsSinceLastAlert = now()->diffInSeconds($lastAlert->created_at);
        $betweenAlertTime = config('king-monitor.alerts.user_between_alert', 1800); // 30 min default

        return $secondsSinceLastAlert > $betweenAlertTime;
    }
}