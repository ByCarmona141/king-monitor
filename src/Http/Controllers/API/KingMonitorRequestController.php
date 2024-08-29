<?php

namespace ByCarmona141\KingMonitor\Http\Controllers\API;

use Illuminate\Routing\Controller;

use ByCarmona141\KingMonitor\Models\KingMonitorRequest;

class KingMonitorRequestController extends Controller {
    /****************************************************************** USER STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- USER STATISTICS TODAY ----------------------------------------------------------------
    public function userRequestStatisticsToday($king_user_id) {
        $king = new KingMonitorRequest();
        return $king->userRequestStatisticsToday($king_user_id);
    }

    public function userRequestMethodStatisticsToday($king_user_id) {
        $king = new KingMonitorRequest();
        return $king->userRequestMethodStatisticsToday($king_user_id);
    }

    // ---------------------------------------------------------------- USER STATISTICS WEEK ----------------------------------------------------------------
    public function userRequestStatisticsWeek($king_user_id) {
        $king = new KingMonitorRequest();
        return $king->userRequestStatisticsWeek($king_user_id);
    }

    public function userRequestMethodStatisticsWeek($king_user_id) {
        $king = new KingMonitorRequest();
        return $king->userRequestMethodStatisticsWeek($king_user_id);
    }

    // ---------------------------------------------------------------- USER STATISTICS MONTH ----------------------------------------------------------------
    public function userRequestStatisticsMonth($king_user_id) {
        $king = new KingMonitorRequest();
        return $king->userRequestStatisticsMonth($king_user_id);
    }

    public function userRequestMethodStatisticsMonth($king_user_id) {
        $king = new KingMonitorRequest();
        return $king->userRequestMethodStatisticsMonth($king_user_id);
    }

    // ---------------------------------------------------------------- USER STATISTICS QUARTER ----------------------------------------------------------------
    public function userRequestStatisticsQuarter($king_user_id) {
        $king = new KingMonitorRequest();
        return $king->userRequestStatisticsQuarter($king_user_id);
    }

    public function userRequestMethodStatisticsQuarter($king_user_id) {
        $king = new KingMonitorRequest();
        return $king->userRequestMethodStatisticsQuarter($king_user_id);
    }

    // ---------------------------------------------------------------- USER STATISTICS YEAR ----------------------------------------------------------------
    public function userRequestStatisticsYear($king_user_id) {
        $king = new KingMonitorRequest();
        return $king->userRequestStatisticsYear($king_user_id);
    }

    public function userRequestMethodStatisticsYear($king_user_id) {
        $king = new KingMonitorRequest();
        return $king->userRequestMethodStatisticsYear($king_user_id);
    }

    // ---------------------------------------------------------------- USER STATISTICS TOTAL ----------------------------------------------------------------
    public function userRequestStatisticsTotal($king_user_id) {
        $king = new KingMonitorRequest();
        return $king->userRequestStatisticsTotal($king_user_id);
    }

    public function userRequestMethodStatisticsTotal($king_user_id) {
        $king = new KingMonitorRequest();
        return $king->userRequestMethodStatisticsTotal($king_user_id);
    }

    /****************************************************************** STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS TODAY ----------------------------------------------------------------
    public function requestStatisticsToday() {
        $king = new KingMonitorRequest();
        return $king->requestStatisticsToday();
    }

    public function requestMethodStatisticsToday() {
        $king = new KingMonitorRequest();
        return $king->requestMethodStatisticsToday();
    }

    public function requestStatisticsFrequentUserToday() {
        $king = new KingMonitorRequest();
        return $king->requestStatisticsFrequentUserToday();
    }

    // ---------------------------------------------------------------- STATISTICS WEEK ----------------------------------------------------------------
    public function requestStatisticsWeek() {
        $king = new KingMonitorRequest();
        return $king->requestStatisticsWeek();
    }

    public function requestMethodStatisticsWeek() {
        $king = new KingMonitorRequest();
        return $king->requestMethodStatisticsWeek();
    }

    public function requestStatisticsFrequentUserWeek() {
        $king = new KingMonitorRequest();
        return $king->requestStatisticsFrequentUserWeek();
    }

    // ---------------------------------------------------------------- STATISTICS MONTH ----------------------------------------------------------------
    public function requestStatisticsMonth() {
        $king = new KingMonitorRequest();
        return $king->requestStatisticsMonth();
    }

    public function requestMethodStatisticsMonth() {
        $king = new KingMonitorRequest();
        return $king->requestMethodStatisticsMonth();
    }

    public function requestStatisticsFrequentUserMonth() {
        $king = new KingMonitorRequest();
        return $king->requestStatisticsFrequentUserMonth();
    }

    // ---------------------------------------------------------------- STATISTICS QUARTER ----------------------------------------------------------------
    public function requestStatisticsQuarter() {
        $king = new KingMonitorRequest();
        return $king->requestStatisticsQuarter();
    }

    public function requestMethodStatisticsQuarter() {
        $king = new KingMonitorRequest();
        return $king->requestMethodStatisticsQuarter();
    }

    public function requestStatisticsFrequentUserQuarter() {
        $king = new KingMonitorRequest();
        return $king->requestStatisticsFrequentUserQuarter();
    }

    // ---------------------------------------------------------------- STATISTICS YEAR ----------------------------------------------------------------
    public function requestStatisticsYear() {
        $king = new KingMonitorRequest();
        return $king->requestStatisticsYear();
    }

    public function requestMethodStatisticsYear() {
        $king = new KingMonitorRequest();
        return $king->requestMethodStatisticsYear();
    }

    public function requestStatisticsFrequentUserYear() {
        $king = new KingMonitorRequest();
        return $king->requestStatisticsFrequentUserYear();
    }

    // ---------------------------------------------------------------- STATISTICS TOTAL ----------------------------------------------------------------
    public function requestStatisticsTotal() {
        $king = new KingMonitorRequest();
        return $king->requestStatisticsTotal();
    }

    public function requestMethodStatisticsTotal() {
        $king = new KingMonitorRequest();
        return $king->requestMethodStatisticsTotal();
    }

    public function requestStatisticsFrequentUserTotal() {
        $king = new KingMonitorRequest();
        return $king->requestStatisticsFrequentUserTotal();
    }

    // ---------------------------------------------------------------- STATISTICS ----------------------------------------------------------------
    public function userRequestStatistics($king_user_id) {
        $king = new KingMonitorRequest();
        return $king->userRequestStatistics($king_user_id);
    }

    public function requestStatistics() {
        $king = new KingMonitorRequest();
        return $king->requestStatistics();
    }

    /****************************************************************** STATISTICS ENDPOINT ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS ENDPOINT TOTAL ----------------------------------------------------------------
    public function requestStatisticsEndpointTotal() {
        $king = new KingMonitorRequest();
        return $king->requestStatisticsEndpointTotal();
    }

    /****************************************************************** HISTORICAL ******************************************************************/
    // ---------------------------------------------------------------- USER HISTORICAL ----------------------------------------------------------------
    public function userRequestHistoricalToday($king_user_id) {
        $king = new KingMonitorRequest();
        return $king->userRequestHistoricalToday($king_user_id);
    }

    public function userRequestHistoricalWeek($king_user_id) {
        $king = new KingMonitorRequest();
        return $king->userRequestHistoricalWeek($king_user_id);
    }

    public function userRequestHistoricalMonth($king_user_id) {
        $king = new KingMonitorRequest();
        return $king->userRequestHistoricalMonth($king_user_id);
    }

    public function userRequestHistoricalQuarter($king_user_id) {
        $king = new KingMonitorRequest();
        return $king->userRequestHistoricalQuarter($king_user_id);
    }

    public function userRequestHistoricalYear($king_user_id) {
        $king = new KingMonitorRequest();
        return $king->userRequestHistoricalYear($king_user_id);
    }

    public function userRequestHistoricalTotal($king_user_id) {
        $king = new KingMonitorRequest();
        return $king->userRequestHistoricalTotal($king_user_id);
    }

    // ---------------------------------------------------------------- HISTORICAL ----------------------------------------------------------------
    public function requestHistoricalToday() {
        $king = new KingMonitorRequest();
        return $king->requestHistoricalToday();
    }

    public function requestHistoricalWeek() {
        $king = new KingMonitorRequest();
        return $king->requestHistoricalWeek();
    }

    public function requestHistoricalMonth() {
        $king = new KingMonitorRequest();
        return $king->requestHistoricalMonth();
    }

    public function requestHistoricalQuarter() {
        $king = new KingMonitorRequest();
        return $king->requestHistoricalQuarter();
    }

    public function requestHistoricalYear() {
        $king = new KingMonitorRequest();
        return $king->requestHistoricalYear();
    }

    public function requestHistoricalTotal() {
        $king = new KingMonitorRequest();
        return $king->requestHistoricalTotal();
    }

    // ---------------------------------------------------------------- HISTORICAL ----------------------------------------------------------------
    public function userRequestHistorical($king_user_id) {
        $king = new KingMonitorRequest();
        return $king->userRequestHistorical($king_user_id);
    }

    public function requestHistorical() {
        $king = new KingMonitorRequest();
        return $king->requestHistorical();
    }

    // ---------------------------------------------------------------- AVG ----------------------------------------------------------------
    public function averageRequestTimeToday() {
        $king = new KingMonitorRequest();
        return $king->averageRequestTimeToday();
    }

    public function averageRequestTimeWeek() {
        $king = new KingMonitorRequest();
        return $king->averageRequestTimeWeek();
    }

    public function averageRequestTimeMonth() {
        $king = new KingMonitorRequest();
        return $king->averageRequestTimeMonth();
    }

    public function averageRequestTimeQuarter() {
        $king = new KingMonitorRequest();
        return $king->averageRequestTimeQuarter();
    }

    public function averageRequestTimeYear() {
        $king = new KingMonitorRequest();
        return $king->averageRequestTimeYear();
    }

    public function averageRequestTimeTotal() {
        $king = new KingMonitorRequest();
        return $king->averageRequestTimeTotal();
    }
}
