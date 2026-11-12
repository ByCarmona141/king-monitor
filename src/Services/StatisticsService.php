<?php
namespace ByCarmona141\KingMonitor\Services;

use ByCarmona141\KingMonitor\Models\KingMonitor;
use ByCarmona141\KingMonitor\Models\KingMonitorError;

class StatisticsService
{
    protected array $periods = ['today', 'week', 'month', 'quarter', 'year', 'total'];

    /**
     * Obtener todas las estadísticas de un usuario
     */
    public function getUserStatistics(?int $userId, string $type = 'all'): array
    {
        $result = [];

        foreach ($this->periods as $period) {
            $result[$period] = match($type) {
                'request' => $this->getRequestStatistics($period, $userId),
                'error' => $this->getErrorStatistics($period, $userId),
                'all' => $this->getCombinedStatistics($period, $userId),
                default => throw new \InvalidArgumentException("Invalid type: {$type}")
            };
        }

        return $result;
    }

    /**
     * Obtener estadísticas combinadas (requests + errors)
     */
    protected function getCombinedStatistics(string $period, ?int $userId = null): array
    {
        $requests = (new KingMonitor())->getStatisticsByPeriod($period, $userId);
        $errors = (new KingMonitorError())->getStatisticsByPeriod($period, $userId);

        return [
            'total' => $requests['total'] + $errors['total'],
            'request' => $requests,
            'error' => $errors,
        ];
    }

    protected function getRequestStatistics(string $period, ?int $userId = null): array
    {
        return (new KingMonitor())->getStatisticsByPeriod($period, $userId);
    }

    protected function getErrorStatistics(string $period, ?int $userId = null): array
    {
        return (new KingMonitorError())->getStatisticsByPeriod($period, $userId);
    }
}