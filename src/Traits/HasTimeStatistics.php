<?php
namespace ByCarmona141\KingMonitor\Traits;

use Carbon\Carbon;

trait HasTimeStatistics
{
    /**
     * Obtener estadísticas basadas en un período de tiempo
     */
    public function getStatisticsByPeriod(string $period, ?int $userId = null): array
    {
        $query = $this->queryForPeriod($period);

        if ($userId) {
            $query->where('king_user_id', $userId);
        }

        return [
            'total' => $query->count(),
            'method' => $this->getMethodStatistics($period, $userId),
        ];
    }

    /**
     * Obtener estadísticas de métodos HTTP
     */
    public function getMethodStatistics(string $period, ?int $userId = null): array
    {
        $methods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];
        $stats = [];

        foreach ($methods as $method) {
            $query = $this->queryForPeriod($period)->where('method', $method);

            if ($userId) {
                $query->where('king_user_id', $userId);
            }

            $stats[$method] = $query->count();
        }

        return $stats;
    }

    /**
     * Query builder basado en período de tiempo
     */
    public function queryForPeriod(string $period)
    {
        return match($period) {
            'today' => static::whereDate('created_at', now()->toDateString()),
            'week' => static::whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]),
            'month' => static::whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month),
            'quarter' => static::whereBetween('created_at', [
                Carbon::now()->startOfQuarter(),
                Carbon::now()->endOfQuarter()
            ]),
            'year' => static::whereYear('created_at', now()->year),
            'total' => static::query(),
            default => throw new \InvalidArgumentException("Invalid period: {$period}")
        };
    }
}
