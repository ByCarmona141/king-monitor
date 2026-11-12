<?php

namespace ByCarmona141\KingMonitor\Services;

use Illuminate\Support\Facades\Log;
use Throwable;
use Illuminate\Support\Arr;
use Illuminate\Auth\AuthenticationException;
use ByCarmona141\KingMonitor\Models\KingMonitorAlert;
use ByCarmona141\KingMonitor\Models\KingMonitorError;
use ByCarmona141\KingMonitor\Models\KingMonitorUserExceeded;
use ByCarmona141\KingMonitor\Http\Controllers\API\KingMonitorMailController;

class KingMonitorErrorService
{
    private static bool $handled = false;

    public function __construct(private KingMonitorMailController $mailer)
    {
    }

    public function handle(Throwable $e): void
    {
        $this->log($e);

        if ($e instanceof AuthenticationException) {
            $this->processUnauthenticated();
        } else if ($this->userExceededErrorLimit()) {
            $this->processLimitExceeded();
        }
    }

    private function log(Throwable $e): void
    {
        KingMonitorError::create([
            'king_user_id' => auth()->id(),
            'method'       => request()->method(),
            'endpoint'     => request()->path(),
            'headers'      => $this->sanitizedHeaders(),
            'token'        => request()->bearerToken(),
            'ip'           => request()->getClientIp(),
            'params'       => filled(request()->input()) ? json_encode(request()->input()) : null,
            'code'         => $this->resolveHttpCode($e),
            'error'        => $e->getCode(),
            'message'      => $e->getMessage(),
        ]);
    }

    private function processUnauthenticated(): void
    {
        $this->registerExceeded();

        if (!config('king-monitor.alerts.monitor_alert')) {
            return;
        }

        $this->mailer->sendAlertUnauthenticated();
        $this->saveAlert();
    }

    private function processLimitExceeded(): void
    {
        $this->registerExceeded();

        if (!config('king-monitor.alerts.monitor_alert')) {
            return;
        }

        $lastAlert = KingMonitorAlert::query()
            ->whereDate('created_at', today())
            ->when(auth()->id(), fn ($q) => $q->where('king_user_id', auth()->id()))
            ->latest()
            ->first();

        $cooldown = config('king-monitor.alerts.user_between_alert');

        if (!$lastAlert || now()->diffInSeconds($lastAlert->created_at) > $cooldown) {
            $this->mailer->sendAlertLimitError();
            $this->saveAlert();
        }
    }

    private function userExceededErrorLimit(): bool
    {
        $userId = auth()->id();
        $token  = request()->bearerToken();

        if (!$userId && !$token) {
            return false;
        }

        $base = KingMonitorError::query()->whereDate('created_at', today());

        $userExceeded  = $userId && $base->clone()
                ->where('king_user_id', $userId)
                ->count() >= config('king-monitor.users.user_errors_limit');

        $tokenExceeded = $token && $base->clone()
                ->where('token', $token)
                ->count() >= config('king-monitor.tokens.token_errors_limit');

        return $userExceeded || $tokenExceeded;
    }

    private function registerExceeded(): void
    {
        if (KingMonitorUserExceeded::alreadyRegisteredToday()) {
            return;
        }

        KingMonitorUserExceeded::create([
            'type'         => KingMonitorUserExceeded::TYPE_ERROR,
            'king_user_id' => auth()->id(),
            'token'        => request()->bearerToken(),
            'ip'           => request()->getClientIp(),
        ]);
    }

    private function saveAlert(): void
    {
        KingMonitorAlert::create([
            'king_user_id' => auth()->id(),
            'token'        => request()->bearerToken(),
            'ip'           => request()->getClientIp(),
        ]);
    }

    private function resolveHttpCode(Throwable $e): int
    {
        if ($e instanceof AuthenticationException) {
            return 401;
        }

        return method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
    }

    private function sanitizedHeaders(): ?string
    {
        if (empty(request()->header())) {
            return null;
        }

        return json_encode(Arr::except(request()->header(), ['authorization']));
    }
}