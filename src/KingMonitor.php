<?php

namespace ByCarmona141\KingMonitor;

use ByCarmona141\KingMonitor\Services\StatisticsService;
use ByCarmona141\KingMonitor\Services\HistoricalService;

class KingMonitor
{
    protected StatisticsService $stats;
    protected HistoricalService $historical;

    public function __construct()
    {
        $this->stats = new StatisticsService();
        $this->historical = new HistoricalService();
    }

    // ============ MONITOR ============
    public function monitor($response, $tuple = null, $withoutResource = false)
    {
        return (new Models\KingMonitor())->monitor($response, $tuple, $withoutResource);
    }

    public function monitorError($error = null, $message = null)
    {
        return (new Models\KingMonitorError())->monitorError($error, $message);
    }

    public function monitorErrorUnauthenticated($error = null, $message = null)
    {
        return (new Models\KingMonitorError())->monitorErrorUnauthenticated($error, $message);
    }

    // ============ STATISTICS (Dynamic) ============
    public function __call($method, $parameters)
    {
        $model = new Models\KingMonitor();

        if (method_exists($model, $method)) {
            return $model->$method(...$parameters);
        }

        $alertModel = new Models\KingMonitorAlert();

        if (method_exists($alertModel, $method)) {
            return $alertModel->$method(...$parameters);
        }

        $exceededModel = new Models\KingMonitorUserExceeded();

        if (method_exists($exceededModel, $method)) {
            return $exceededModel->$method(...$parameters);
        }

        if (method_exists($this->stats, $method)) {
            return $this->stats->$method(...$parameters);
        }

        throw new \BadMethodCallException("Method {$method} does not exist.");
    }

    // ============ ESPECÍFICOS (si es necesario compatibilidad) ============
    public function statistics()
    {
        return $this->stats->getUserStatistics(null, 'all');
    }

    public function userStatistics(int $userId)
    {
        return $this->stats->getUserStatistics($userId, 'all');
    }

    public function historical()
    {
        return $this->historical->getUserHistorical(null, 'all');
    }

    public function userHistorical(int $userId)
    {
        return $this->historical->getUserHistorical($userId, 'all');
    }
}