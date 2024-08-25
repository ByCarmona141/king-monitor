<?php

namespace ByCarmona141\KingMonitor\Http\Controllers\API;

use Illuminate\Routing\Controller;

use ByCarmona141\KingMonitor\Models\KingMonitorAlert;

/**
 * @OA\Info(title="KingMonitor", version="1.0")
 *
 * @OA\Server(url="http://localhost/api/v1")
 */

class KingMonitorAlertController extends Controller {
    /**
     * Obtiene la ultima alerta del usuario
     */
    public function lastAlertToday() {
        $king = new KingMonitorAlert();
        return $king->lastAlertToday();
    }

    /**
     * Obtiene la estatistica de alertas del usuario (today)
     */
    public function userStatisticsToday($kingUserId) {
        $king = new KingMonitorAlert();
        return $king->userStatisticsToday($kingUserId);
    }

    /**
     * Obtiene la estatistica de alertas del usuario (week)
     */
    public function userStatisticsWeek($kingUserId) {
        $king = new KingMonitorAlert();
        return $king->userStatisticsWeek($kingUserId);
    }

    /**
     * Obtiene la estatistica de alertas del usuario (month)
     */
    public function userStatisticsMonth($kingUserId) {
        $king = new KingMonitorAlert();
        return $king->userStatisticsMonth($kingUserId);
    }

    /**
     * Obtiene la estatistica de alertas del usuario (quarter)
     */
    public function userStatisticsQuarter($kingUserId) {
        $king = new KingMonitorAlert();
        return $king->userStatisticsQuarter($kingUserId);
    }

    /**
     * Obtiene la estatistica de alertas del usuario (year)
     */
    public function userStatisticsYear($kingUserId) {
        $king = new KingMonitorAlert();
        return $king->userStatisticsYear($kingUserId);
    }

    /**
     * Obtiene la estatistica de alertas del usuario (total)
     */
    public function userStatisticsTotal($kingUserId) {
        $king = new KingMonitorAlert();
        return $king->userStatisticsTotal($kingUserId);
    }

    /**
     * Obtiene la estatistica de alertas (today)
     */
    public function statisticsToday() {
        $king = new KingMonitorAlert();
        return $king->statisticsToday();
    }

    /**
     * Obtiene la estatistica de alertas (week)
     */
    public function statisticsWeek() {
        $king = new KingMonitorAlert();
        return $king->statisticsWeek();
    }

    /**
     * Obtiene la estatistica de alertas (month)
     */
    public function statisticsMonth() {
        $king = new KingMonitorAlert();
        return $king->statisticsMonth();
    }

    /**
     * Obtiene la estatistica de alertas (quarter)
     */
    public function statisticsQuarter() {
        $king = new KingMonitorAlert();
        return $king->statisticsQuarter();
    }

    /**
     * Obtiene la estatistica de alertas (year)
     */
    public function statisticsYear() {
        $king = new KingMonitorAlert();
        return $king->statisticsYear();
    }

    /**
     * Obtiene la estatistica de alertas (total)
     */
    public function statisticsTotal() {
        $king = new KingMonitorAlert();
        return $king->statisticsTotal();
    }

    /**
     * Obtiene el historico de alertas del usuario (today)
     */
    public function userHistoricalToday($kingUserId) {
        $king = new KingMonitorAlert();
        return $king->userHistoricalToday($kingUserId);
    }

    /**
     * Obtiene el historico de alertas del usuario (week)
     */
    public function userHistoricalWeek($kingUserId) {
        $king = new KingMonitorAlert();
        return $king->userHistoricalWeek($kingUserId);
    }

    /**
     * Obtiene el historico de alertas del usuario (month)
     */
    public function userHistoricalMonth($kingUserId) {
        $king = new KingMonitorAlert();
        return $king->userHistoricalMonth($kingUserId);
    }

    /**
     * Obtiene el historico de alertas del usuario (quarter)
     */
    public function userHistoricalQuarter($kingUserId) {
        $king = new KingMonitorAlert();
        return $king->userHistoricalQuarter($kingUserId);
    }

    /**
     * Obtiene el historico de alertas del usuario (year)
     */
    public function userHistoricalYear($kingUserId) {
        $king = new KingMonitorAlert();
        return $king->userHistoricalYear($kingUserId);
    }

    /**
     * Obtiene el historico de alertas del usuario (total)
     */
    public function userHistoricalTotal($kingUserId) {
        $king = new KingMonitorAlert();
        return $king->userHistoricalTotal($kingUserId);
    }

    /**
     * Obtiene el historico de alertas (today)
     */
    public function historicalToday() {
        $king = new KingMonitorAlert();
        return $king->historicalToday();
    }

    /**
     * Obtiene el historico de alertas (week)
     */
    public function historicalWeek() {
        $king = new KingMonitorAlert();
        return $king->historicalWeek();
    }

    /**
     * Obtiene el historico de alertas (month)
     */
    public function historicalMonth() {
        $king = new KingMonitorAlert();
        return $king->historicalMonth();
    }

    /**
     * Obtiene el historico de alertas (quarter)
     */
    public function historicalQuarter() {
        $king = new KingMonitorAlert();
        return $king->historicalQuarter();
    }

    /**
     * Obtiene el historico de alertas (year)
     */
    public function historicalYear() {
        $king = new KingMonitorAlert();
        return $king->historicalYear();
    }

    /**
     * Obtiene el historico de alertas (total)
     */
    public function historicalTotal() {
        $king = new KingMonitorAlert();
        return $king->historicalTotal();
    }
}
