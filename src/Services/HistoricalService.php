<?php
namespace ByCarmona141\KingMonitor\Services;

use ByCarmona141\KingMonitor\Models\KingMonitor;
use ByCarmona141\KingMonitor\Models\KingMonitorError;

class HistoricalService
{
    protected array $periods = ['today', 'week', 'month', 'quarter', 'year', 'total'];

    /**
     * Obtener todo el histórico de un usuario
     */
    public function getUserHistorical(?int $userId, string $type = 'all'): array
    {
        $result = [];

        foreach ($this->periods as $period) {
            $result[$period] = match($type) {
                'request' => $this->getRequestHistorical($period, $userId),
                'error' => $this->getErrorHistorical($period, $userId),
                'all' => $this->getCombinedHistorical($period, $userId),
                default => throw new \InvalidArgumentException("Invalid type: {$type}")
            };
        }

        return $result;
    }

    protected function getCombinedHistorical(string $period, ?int $userId = null): array
    {
        return [
            'request' => $this->getRequestHistorical($period, $userId),
            'error' => $this->getErrorHistorical($period, $userId),
        ];
    }

    protected function getRequestHistorical(string $period, ?int $userId = null): array
    {
        return (new KingMonitor())->getHistoricalByPeriod($period, $userId);
    }

    protected function getErrorHistorical(string $period, ?int $userId = null): array
    {
        return (new KingMonitorError())->getHistoricalByPeriod($period, $userId);
    }
}