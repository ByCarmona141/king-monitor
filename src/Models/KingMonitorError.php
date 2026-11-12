<?php

namespace ByCarmona141\KingMonitor\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt; // Para encriptar los datos
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use ByCarmona141\KingMonitor\Traits\HasTimeStatistics;
use ByCarmona141\KingMonitor\Traits\HasTimeHistorical;
use ByCarmona141\KingMonitor\Services\MonitorAlertService;

class KingMonitorError extends Model
{
    use HasFactory, HasTimeStatistics, HasTimeHistorical;

    protected $fillable = [
        'king_user_id', 'method', 'endpoint',
        'headers', 'token', 'ip', 'params',
        'code', 'error', 'message',
    ];

    protected $casts = [
        'id' => 'integer',
        'king_user_id' => 'integer',
    ];

    /**
     * Verificar si el usuario excedió el límite de errores
     */
    public function hasExceededLimit(): bool
    {
        if (!auth()->check()) {
            return false;
        }

        $userLimit = $this->queryForPeriod('today')
            ->where('king_user_id', auth()->id())
            ->count();

        $tokenLimit = $this->queryForPeriod('today')
            ->where('token', request()->bearerToken())
            ->count();

        return $userLimit >= config('king-monitor.users.user_errors_limit')
            || $tokenLimit >= config('king-monitor.users.token_errors_limit');
    }

    /**
     * Método principal de monitoreo de errores
     */
    public function monitorError($error = null, $message = null): self
    {
        $this->fill([
            'king_user_id' => auth()->id(),
            'method' => request()->method(),
            'endpoint' => request()->path(),
            'headers' => $this->sanitizeHeaders(request()->header()),
            'token' => request()->bearerToken(),
            'ip' => request()->getClientIp(),
            'params' => $this->sanitizeParams(request()->input()),
            'code' => $this->extractErrorCode($error),
            'error' => $error?->getCode(),
            'message' => $message ?? $error?->getMessage(),
        ]);

        $this->save();

        // Manejar límites y alertas
        $this->handleLimitsAndAlerts();

        return $this;
    }

    /**
     * Monitorear error de autenticación
     */
    public function monitorErrorUnauthenticated($error = null, $message = null): self
    {
        $this->fill([
            'king_user_id' => auth()->id(),
            'method' => request()->method(),
            'endpoint' => request()->path(),
            'headers' => $this->sanitizeHeaders(request()->header()),
            'token' => request()->bearerToken(),
            'ip' => request()->getClientIp(),
            'params' => $this->sanitizeParams(request()->input()),
            'code' => 401,
            'error' => $error?->getCode(),
            'message' => $message ?? $error?->getMessage(),
        ]);

        $this->save();

        // Siempre enviar alerta para errores de autenticación
        if (config('king-monitor.alerts.monitor_alert')) {
            app(MonitorAlertService::class)->sendUnauthenticatedAlert();
        }

        return $this;
    }

    // Métodos helper privados
    private function sanitizeHeaders(?array $headers): ?string
    {
        if (!$headers) return null;

        return json_encode(Arr::except($headers, ['authorization']));
    }

    private function sanitizeParams($params): ?string
    {
        if (!$params || empty($params)) return null;

        return json_encode($params);
    }

    private function extractErrorCode($error): int
    {
        if (!$error) {
            return 500;
        }

        if (!method_exists($error, 'getStatusCode')) {
            return 500;
        }

        return $error->getStatusCode();
    }

    private function handleLimitsAndAlerts(): void
    {
        if (!$this->hasExceededLimit()) {
            return;
        }

        app(MonitorAlertService::class)->handleExceededLimit('error');
    }
}