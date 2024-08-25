<?php

namespace ByCarmona141\KingMonitor;

use ByCarmona141\KingMonitor\Models\KingMonitor as KingMonitorModel;

class KingMonitor {
    /*
    * Mandamos el booleano que nos dice sobre el limite de peticiones al dia del usuario
    */
    public function limit() {
        $kingMonitor = new KingMonitorModel();
        return $kingMonitor->limit();
    }

    /*********************************************** MONITOR ***********************************************/
    public function monitor($response, $tuple = NULL, $withoutResource = FALSE) {
        $kingMonitor = new KingMonitorModel();
        return $kingMonitor->monitor($response, $tuple, $withoutResource);
    }

    public function monitorError($king_type_error_id, $error = NULL, $message = NULL) {
        $kingMonitor = new KingMonitorModel();
        return $kingMonitor->monitorError($king_type_error_id, $error, $message);
    }

    public function monitorErrorUnauthenticated($king_type_error_id, $error = NULL, $message = NULL) {
        $kingMonitor = new KingMonitorModel();
        return $kingMonitor->monitorErrorUnauthenticated($king_type_error_id, $error, $message);
    }

    /****************************************************************** USER STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- USER STATISTICS TODAY ----------------------------------------------------------------
    public function userStatisticsToday($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userStatisticsToday($king_user_id);
    }

    public function userMethodStatisticsToday($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userMethodStatisticsToday($king_user_id);
    }

    // ---------------------------------------------------------------- USER STATISTICS WEEK ----------------------------------------------------------------
    public function userStatisticsWeek($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userStatisticsWeek($king_user_id);
    }

    public function userMethodStatisticsWeek($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userMethodStatisticsWeek($king_user_id);
    }

    // ---------------------------------------------------------------- USER STATISTICS MONTH ----------------------------------------------------------------
    public function userStatisticsMonth($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userStatisticsMonth($king_user_id);
    }

    public function userMethodStatisticsMonth($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userMethodStatisticsMonth($king_user_id);
    }

    // ---------------------------------------------------------------- USER STATISTICS QUARTER ----------------------------------------------------------------
    public function userStatisticsQuarter($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userStatisticsQuarter($king_user_id);
    }

    public function userMethodStatisticsQuarter($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userMethodStatisticsQuarter($king_user_id);
    }

    // ---------------------------------------------------------------- USER STATISTICS YEAR ----------------------------------------------------------------
    public function userStatisticsYear($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userStatisticsYear($king_user_id);
    }

    public function userMethodStatisticsYear($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userMethodStatisticsYear($king_user_id);
    }

    // ---------------------------------------------------------------- USER STATISTICS TOTAL ----------------------------------------------------------------
    public function userStatisticsTotal($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userStatisticsTotal($king_user_id);
    }

    public function userMethodStatisticsTotal($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userMethodStatisticsTotal($king_user_id);
    }

    /****************************************************************** USER REQUEST STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- USER REQUEST STATISTICS TODAY ----------------------------------------------------------------
    public function userRequestStatisticsToday($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestStatisticsToday($king_user_id);
    }

    public function userRequestMethodStatisticsToday($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestMethodStatisticsToday($king_user_id);
    }

    // ---------------------------------------------------------------- USER REQUEST STATISTICS WEEK ----------------------------------------------------------------
    public function userRequestStatisticsWeek($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestStatisticsWeek($king_user_id);
    }

    public function userRequestMethodStatisticsWeek($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestMethodStatisticsWeek($king_user_id);
    }

    // ---------------------------------------------------------------- USER REQUEST STATISTICS MONTH ----------------------------------------------------------------
    public function userRequestStatisticsMonth($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestStatisticsMonth($king_user_id);
    }

    public function userRequestMethodStatisticsMonth($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestMethodStatisticsMonth($king_user_id);
    }

    // ---------------------------------------------------------------- USER REQUEST STATISTICS QUARTER ----------------------------------------------------------------
    public function userRequestStatisticsQuarter($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestStatisticsQuarter($king_user_id);
    }

    public function userRequestMethodStatisticsQuarter($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestMethodStatisticsQuarter($king_user_id);
    }

    // ---------------------------------------------------------------- USER REQUEST STATISTICS YEAR ----------------------------------------------------------------
    public function userRequestStatisticsYear($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestStatisticsYear($king_user_id);
    }

    public function userRequestMethodStatisticsYear($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestMethodStatisticsYear($king_user_id);
    }

    // ---------------------------------------------------------------- USER REQUEST STATISTICS TOTAL ----------------------------------------------------------------
    public function userRequestStatisticsTotal($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestStatisticsTotal($king_user_id);
    }

    public function userRequestMethodStatisticsTotal($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestMethodStatisticsTotal($king_user_id);
    }

    /****************************************************************** REQUEST STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- REQUEST STATISTICS TODAY ----------------------------------------------------------------
    public function requestStatisticsToday() {
        $king = new KingMonitorModel();
        return $king->requestStatisticsToday();
    }

    public function requestMethodStatisticsToday() {
        $king = new KingMonitorModel();
        return $king->requestMethodStatisticsToday();
    }

    public function requestStatisticsFrequentUserToday() {
        $king = new KingMonitorModel();
        return $king->requestStatisticsFrequentUserToday();
    }

    // ---------------------------------------------------------------- REQUEST STATISTICS WEEK ----------------------------------------------------------------
    public function requestStatisticsWeek() {
        $king = new KingMonitorModel();
        return $king->requestStatisticsWeek();
    }

    public function requestMethodStatisticsWeek() {
        $king = new KingMonitorModel();
        return $king->requestMethodStatisticsWeek();
    }

    public function requestStatisticsFrequentUserWeek() {
        $king = new KingMonitorModel();
        return $king->requestStatisticsFrequentUserWeek();
    }

    // ---------------------------------------------------------------- REQUEST STATISTICS MONTH ----------------------------------------------------------------
    public function requestStatisticsMonth() {
        $king = new KingMonitorModel();
        return $king->requestStatisticsMonth();
    }

    public function requestMethodStatisticsMonth() {
        $king = new KingMonitorModel();
        return $king->requestMethodStatisticsMonth();
    }

    public function requestStatisticsFrequentUserMonth() {
        $king = new KingMonitorModel();
        return $king->requestStatisticsFrequentUserMonth();
    }

    // ---------------------------------------------------------------- REQUEST STATISTICS QUARTER ----------------------------------------------------------------
    public function requestStatisticsQuarter() {
        $king = new KingMonitorModel();
        return $king->requestStatisticsQuarter();
    }

    public function requestMethodStatisticsQuarter() {
        $king = new KingMonitorModel();
        return $king->requestMethodStatisticsQuarter();
    }

    public function requestStatisticsFrequentUserQuarter() {
        $king = new KingMonitorModel();
        return $king->requestStatisticsFrequentUserQuarter();
    }

    // ---------------------------------------------------------------- REQUEST STATISTICS YEAR ----------------------------------------------------------------
    public function requestStatisticsYear() {
        $king = new KingMonitorModel();
        return $king->requestStatisticsYear();
    }

    public function requestMethodStatisticsYear() {
        $king = new KingMonitorModel();
        return $king->requestMethodStatisticsYear();
    }

    public function requestStatisticsFrequentUserYear() {
        $king = new KingMonitorModel();
        return $king->requestStatisticsFrequentUserYear();
    }

    // ---------------------------------------------------------------- REQUEST STATISTICS TOTAL ----------------------------------------------------------------
    public function requestStatisticsTotal() {
        $king = new KingMonitorModel();
        return $king->requestStatisticsTotal();
    }

    public function requestMethodStatisticsTotal() {
        $king = new KingMonitorModel();
        return $king->requestMethodStatisticsTotal();
    }

    public function requestStatisticsFrequentUserTotal() {
        $king = new KingMonitorModel();
        return $king->requestStatisticsFrequentUserTotal();
    }

    /****************************************************************** USER ERRORS STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- USER ERROR STATISTICS TODAY ----------------------------------------------------------------
    public function userErrorStatisticsToday($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorStatisticsToday($king_user_id);
    }

    public function userErrorMethodStatisticsToday($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorMethodStatisticsToday($king_user_id);
    }

    // ---------------------------------------------------------------- USER ERROR STATISTICS WEEK ----------------------------------------------------------------
    public function userErrorStatisticsWeek($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorStatisticsWeek($king_user_id);
    }

    public function userErrorMethodStatisticsWeek($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorMethodStatisticsWeek($king_user_id);
    }

    // ---------------------------------------------------------------- USER ERROR STATISTICS MONTH ----------------------------------------------------------------
    public function userErrorStatisticsMonth($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorStatisticsMonth($king_user_id);
    }

    public function userErrorMethodStatisticsMonth($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorMethodStatisticsMonth($king_user_id);
    }

    // ---------------------------------------------------------------- USER ERROR STATISTICS QUARTER ----------------------------------------------------------------
    public function userErrorStatisticsQuarter($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorStatisticsQuarter($king_user_id);
    }

    public function userErrorMethodStatisticsQuarter($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorMethodStatisticsQuarter($king_user_id);
    }

    // ---------------------------------------------------------------- USER ERROR STATISTICS YEAR ----------------------------------------------------------------
    public function userErrorStatisticsYear($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorStatisticsYear($king_user_id);
    }

    public function userErrorMethodStatisticsYear($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorMethodStatisticsYear($king_user_id);
    }

    // ---------------------------------------------------------------- USER ERROR STATISTICS TOTAL ----------------------------------------------------------------
    public function userErrorStatisticsTotal($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorStatisticsTotal($king_user_id);
    }

    public function userErrorMethodStatisticsTotal($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorMethodStatisticsTotal($king_user_id);
    }

    /****************************************************************** ERROR STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- ERROR STATISTICS TODAY ----------------------------------------------------------------
    public function errorStatisticsToday() {
        $king = new KingMonitorModel();
        return $king->errorStatisticsToday();
    }

    public function errorMethodStatisticsToday() {
        $king = new KingMonitorModel();
        return $king->errorMethodStatisticsToday();
    }

    public function errorStatisticsFrequentUserToday() {
        $king = new KingMonitorModel();
        return $king->errorStatisticsFrequentUserToday();
    }

    // ---------------------------------------------------------------- ERROR STATISTICS WEEK ----------------------------------------------------------------
    public function errorStatisticsWeek() {
        $king = new KingMonitorModel();
        return $king->errorStatisticsWeek();
    }

    public function errorMethodStatisticsWeek() {
        $king = new KingMonitorModel();
        return $king->errorMethodStatisticsWeek();
    }

    public function errorStatisticsFrequentUserWeek() {
        $king = new KingMonitorModel();
        return $king->errorStatisticsFrequentUserWeek();
    }

    // ---------------------------------------------------------------- ERROR STATISTICS MONTH ----------------------------------------------------------------
    public function errorStatisticsMonth() {
        $king = new KingMonitorModel();
        return $king->errorStatisticsMonth();
    }

    public function errorMethodStatisticsMonth() {
        $king = new KingMonitorModel();
        return $king->errorMethodStatisticsMonth();
    }

    public function errorStatisticsFrequentUserMonth() {
        $king = new KingMonitorModel();
        return $king->errorStatisticsFrequentUserMonth();
    }

    // ---------------------------------------------------------------- ERROR STATISTICS QUARTER ----------------------------------------------------------------
    public function errorStatisticsQuarter() {
        $king = new KingMonitorModel();
        return $king->errorStatisticsQuarter();
    }

    public function errorMethodStatisticsQuarter() {
        $king = new KingMonitorModel();
        return $king->errorMethodStatisticsQuarter();
    }

    public function errorStatisticsFrequentUserQuarter() {
        $king = new KingMonitorModel();
        return $king->errorStatisticsFrequentUserQuarter();
    }

    // ---------------------------------------------------------------- ERROR STATISTICS YEAR ----------------------------------------------------------------
    public function errorStatisticsYear() {
        $king = new KingMonitorModel();
        return $king->errorStatisticsYear();
    }

    public function errorMethodStatisticsYear() {
        $king = new KingMonitorModel();
        return $king->errorMethodStatisticsYear();
    }

    public function errorStatisticsFrequentUserYear() {
        $king = new KingMonitorModel();
        return $king->errorStatisticsFrequentUserYear();
    }

    // ---------------------------------------------------------------- ERROR STATISTICS TOTAL ----------------------------------------------------------------
    public function errorStatisticsTotal() {
        $king = new KingMonitorModel();
        return $king->errorStatisticsTotal();
    }

    public function errorMethodStatisticsTotal() {
        $king = new KingMonitorModel();
        return $king->errorMethodStatisticsTotal();
    }

    public function errorStatisticsFrequentUserTotal() {
        $king = new KingMonitorModel();
        return $king->errorStatisticsFrequentUserTotal();
    }

    // ---------------------------------------------------------------- STATISTICS ENDPOINTS ----------------------------------------------------------------
    public function requestStatisticsEndpointTotal() {
        $king = new KingMonitorModel();
        return $king->requestStatisticsEndpointTotal();
    }

    public function errorStatisticsEndpointTotal() {
        $king = new KingMonitorModel();
        return $king->errorStatisticsEndpointTotal();
    }

    /****************************************************************** STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS TODAY ----------------------------------------------------------------
    public function statisticsToday() {
        $king = new KingMonitorModel();
        return $king->statisticsToday();
    }

    public function methodStatisticsToday() {
        $king = new KingMonitorModel();
        return $king->methodStatisticsToday();
    }

    public function statisticsFrequentUserToday() {
        $king = new KingMonitorModel();
        return $king->statisticsFrequentUserToday();
    }

    // ---------------------------------------------------------------- STATISTICS WEEK ----------------------------------------------------------------
    public function statisticsWeek() {
        $king = new KingMonitorModel();
        return $king->statisticsWeek();
    }

    public function methodStatisticsWeek() {
        $king = new KingMonitorModel();
        return $king->methodStatisticsWeek();
    }

    public function statisticsFrequentUserWeek() {
        $king = new KingMonitorModel();
        return $king->statisticsFrequentUserWeek();
    }

    // ---------------------------------------------------------------- STATISTICS MONTH ----------------------------------------------------------------
    public function statisticsMonth() {
        $king = new KingMonitorModel();
        return $king->statisticsMonth();
    }

    public function methodStatisticsMonth() {
        $king = new KingMonitorModel();
        return $king->methodStatisticsMonth();
    }

    public function statisticsFrequentUserMonth() {
        $king = new KingMonitorModel();
        return $king->statisticsFrequentUserMonth();
    }

    // ---------------------------------------------------------------- STATISTICS QUARTER ----------------------------------------------------------------
    public function statisticsQuarter() {
        $king = new KingMonitorModel();
        return $king->statisticsQuarter();
    }

    public function methodStatisticsQuarter() {
        $king = new KingMonitorModel();
        return $king->methodStatisticsQuarter();
    }

    public function statisticsFrequentUserQuarter() {
        $king = new KingMonitorModel();
        return $king->statisticsFrequentUserQuarter();
    }

    // ---------------------------------------------------------------- STATISTICS YEAR ----------------------------------------------------------------
    public function statisticsYear() {
        $king = new KingMonitorModel();
        return $king->statisticsYear();
    }

    public function methodStatisticsYear() {
        $king = new KingMonitorModel();
        return $king->methodStatisticsYear();
    }

    public function statisticsFrequentUserYear() {
        $king = new KingMonitorModel();
        return $king->statisticsFrequentUserYear();
    }

    // ---------------------------------------------------------------- STATISTICS TOTAL ----------------------------------------------------------------
    public function statisticsTotal() {
        $king = new KingMonitorModel();
        return $king->statisticsTotal();
    }

    public function methodStatisticsTotal() {
        $king = new KingMonitorModel();
        return $king->methodStatisticsTotal();
    }

    public function statisticsFrequentUserTotal() {
        $king = new KingMonitorModel();
        return $king->statisticsFrequentUserTotal();
    }

    /*********************************************** STATISTICS ***********************************************/
    public function statistics() {
        $king = new KingMonitorModel();
        return $king->statistics();
    }

    public function userStatistics($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userStatistics($king_user_id);
    }

    public function userRequestStatistics($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestStatistics($king_user_id);
    }

    public function errorStatistics() {
        $king = new KingMonitorModel();
        return $king->errorStatistics();
    }

    public function userErrorStatistics($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorStatistics($king_user_id);
    }

    public function requestStatistics() {
        $king = new KingMonitorModel();
        return $king->requestStatistics();
    }

    /****************************************************************** USER STATISTICS EXCEEDED ******************************************************************/
    /****************************************************************** USER REQUEST STATISTICS EXCEEDED ******************************************************************/
    public function userRequestStatisticsExceededToday($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestStatisticsExceededToday($king_user_id);
    }

    public function userRequestStatisticsExceededWeek($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestStatisticsExceededWeek($king_user_id);
    }

    public function userRequestStatisticsExceededMonth($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestStatisticsExceededMonth($king_user_id);
    }

    public function userRequestStatisticsExceededQuarter($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestStatisticsExceededQuarter($king_user_id);
    }

    public function userRequestStatisticsExceededYear($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestStatisticsExceededYear($king_user_id);
    }

    public function userRequestStatisticsExceededTotal($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestStatisticsExceededTotal($king_user_id);
    }

    /****************************************************************** USER ERROR STATISTICS EXCEEDED ******************************************************************/
    public function userErrorStatisticsExceededToday($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorStatisticsExceededToday($king_user_id);
    }

    public function userErrorStatisticsExceededWeek($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorStatisticsExceededWeek($king_user_id);
    }

    public function userErrorStatisticsExceededMonth($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorStatisticsExceededMonth($king_user_id);
    }

    public function userErrorStatisticsExceededQuarter($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorStatisticsExceededQuarter($king_user_id);
    }

    public function userErrorStatisticsExceededYear($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorStatisticsExceededYear($king_user_id);
    }

    public function userErrorStatisticsExceededTotal($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorStatisticsExceededTotal($king_user_id);
    }

    /****************************************************************** USER STATISTICS EXCEEDED ******************************************************************/
    public function userStatisticsExceededToday($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userStatisticsExceededToday($king_user_id);
    }

    public function userStatisticsExceededWeek($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userStatisticsExceededWeek($king_user_id);
    }

    public function userStatisticsExceededMonth($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userStatisticsExceededMonth($king_user_id);
    }

    public function userStatisticsExceededQuarter($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userStatisticsExceededQuarter($king_user_id);
    }

    public function userStatisticsExceededYear($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userStatisticsExceededYear($king_user_id);
    }

    public function userStatisticsExceededTotal($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userStatisticsExceededTotal($king_user_id);
    }

    /****************************************************************** USER STATISTICS EXCEEDED ******************************************************************/
    public function userRequestStatisticsExceeded($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestStatisticsExceeded($king_user_id);
    }

    public function userErrorStatisticsExceeded($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorStatisticsExceeded($king_user_id);
    }

    public function userStatisticsExceeded($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userStatisticsExceeded($king_user_id);
    }

    /****************************************************************** STATISTICS EXCEEDED ******************************************************************/
    /****************************************************************** STATISTICS EXCEEDED REQUEST ******************************************************************/
    public function requestStatisticsExceededToday() {
        $king = new KingMonitorModel();
        return $king->requestStatisticsExceededToday();
    }

    public function requestStatisticsExceededWeek() {
        $king = new KingMonitorModel();
        return $king->requestStatisticsExceededWeek();
    }

    public function requestStatisticsExceededMonth() {
        $king = new KingMonitorModel();
        return $king->requestStatisticsExceededMonth();
    }

    public function requestStatisticsExceededQuarter() {
        $king = new KingMonitorModel();
        return $king->requestStatisticsExceededQuarter();
    }

    public function requestStatisticsExceededYear() {
        $king = new KingMonitorModel();
        return $king->requestStatisticsExceededYear();
    }

    public function requestStatisticsExceededTotal() {
        $king = new KingMonitorModel();
        return $king->requestStatisticsExceededTotal();
    }

    /****************************************************************** ERROR STATISTICS EXCEEDED ******************************************************************/
    public function errorStatisticsExceededToday() {
        $king = new KingMonitorModel();
        return $king->errorStatisticsExceededToday();
    }

    public function errorStatisticsExceededWeek() {
        $king = new KingMonitorModel();
        return $king->errorStatisticsExceededWeek();
    }

    public function errorStatisticsExceededMonth() {
        $king = new KingMonitorModel();
        return $king->errorStatisticsExceededMonth();
    }

    public function errorStatisticsExceededQuarter() {
        $king = new KingMonitorModel();
        return $king->errorStatisticsExceededQuarter();
    }

    public function errorStatisticsExceededYear() {
        $king = new KingMonitorModel();
        return $king->errorStatisticsExceededYear();
    }

    public function errorStatisticsExceededTotal() {
        $king = new KingMonitorModel();
        return $king->errorStatisticsExceededTotal();
    }

    /****************************************************************** STATISTICS EXCEEDED ******************************************************************/
    public function statisticsExceededToday() {
        $king = new KingMonitorModel();
        return $king->statisticsExceededToday();
    }

    public function statisticsExceededWeek() {
        $king = new KingMonitorModel();
        return $king->statisticsExceededWeek();
    }

    public function statisticsExceededMonth() {
        $king = new KingMonitorModel();
        return $king->statisticsExceededMonth();
    }

    public function statisticsExceededQuarter() {
        $king = new KingMonitorModel();
        return $king->statisticsExceededQuarter();
    }

    public function statisticsExceededYear() {
        $king = new KingMonitorModel();
        return $king->statisticsExceededYear();
    }

    public function statisticsExceededTotal() {
        $king = new KingMonitorModel();
        return $king->statisticsExceededTotal();
    }

    /****************************************************************** STATISTICS EXCEEDED ******************************************************************/
    public function requestStatisticsExceeded() {
        $king = new KingMonitorModel();
        return $king->requestStatisticsExceeded();
    }

    public function errorStatisticsExceeded() {
        $king = new KingMonitorModel();
        return $king->errorStatisticsExceeded();
    }

    public function statisticsExceeded() {
        $king = new KingMonitorModel();
        return $king->statisticsExceeded();
    }

    /****************************************************************** HISTORICAL EXCEEDED ******************************************************************/
    /****************************************************************** USER HISTORICAL EXCEEDED ******************************************************************/
    // ---------------------------------------------------------------- USER REQUEST HISTORICAL EXCEEDED ----------------------------------------------------------------
    public function userRequestHistoricalExceededToday($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestHistoricalExceededToday($king_user_id);
    }

    public function userRequestHistoricalExceededWeek($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestHistoricalExceededWeek($king_user_id);
    }

    public function userRequestHistoricalExceededMonth($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestHistoricalExceededMonth($king_user_id);
    }

    public function userRequestHistoricalExceededQuarter($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestHistoricalExceededQuarter($king_user_id);
    }

    public function userRequestHistoricalExceededYear($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestHistoricalExceededYear($king_user_id);
    }

    public function userRequestHistoricalExceededTotal($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestHistoricalExceededTotal($king_user_id);
    }

    // ---------------------------------------------------------------- USER ERROR HISTORICAL EXCEEDED ----------------------------------------------------------------
    public function userErrorHistoricalExceededToday($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorHistoricalExceededToday($king_user_id);
    }

    public function userErrorHistoricalExceededWeek($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorHistoricalExceededWeek($king_user_id);
    }

    public function userErrorHistoricalExceededMonth($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorHistoricalExceededMonth($king_user_id);
    }

    public function userErrorHistoricalExceededQuarter($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorHistoricalExceededQuarter($king_user_id);
    }

    public function userErrorHistoricalExceededYear($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorHistoricalExceededYear($king_user_id);
    }

    public function userErrorHistoricalExceededTotal($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorHistoricalExceededTotal($king_user_id);
    }

    // ---------------------------------------------------------------- USER HISTORICAL EXCEEDED ----------------------------------------------------------------
    public function userHistoricalExceededToday($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userHistoricalExceededToday($king_user_id);
    }

    public function userHistoricalExceededWeek($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userHistoricalExceededWeek($king_user_id);
    }

    public function userHistoricalExceededMonth($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userHistoricalExceededMonth($king_user_id);
    }

    public function userHistoricalExceededQuarter($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userHistoricalExceededQuarter($king_user_id);
    }

    public function userHistoricalExceededYear($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userHistoricalExceededYear($king_user_id);
    }

    public function userHistoricalExceededTotal($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userHistoricalExceededTotal($king_user_id);
    }

    // ---------------------------------------------------------------- USER HISTORICAL EXCEEDED ----------------------------------------------------------------
    public function userRequestHistoricalExceeded($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestHistoricalExceeded($king_user_id);
    }

    public function userErrorHistoricalExceeded($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorHistoricalExceeded($king_user_id);
    }

    public function userHistoricalExceeded($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userHistoricalExceeded($king_user_id);
    }

    /****************************************************************** HISTORICAL EXCEEDED ******************************************************************/
    // ---------------------------------------------------------------- REQUEST HISTORICAL EXCEEDED ----------------------------------------------------------------
    public function requestHistoricalExceededToday() {
        $king = new KingMonitorModel();
        return $king->requestHistoricalExceededToday();
    }

    public function requestHistoricalExceededWeek() {
        $king = new KingMonitorModel();
        return $king->requestHistoricalExceededWeek();
    }

    public function requestHistoricalExceededMonth() {
        $king = new KingMonitorModel();
        return $king->requestHistoricalExceededMonth();
    }

    public function requestHistoricalExceededQuarter() {
        $king = new KingMonitorModel();
        return $king->requestHistoricalExceededQuarter();
    }

    public function requestHistoricalExceededYear() {
        $king = new KingMonitorModel();
        return $king->requestHistoricalExceededYear();
    }

    public function requestHistoricalExceededTotal() {
        $king = new KingMonitorModel();
        return $king->requestHistoricalExceededTotal();
    }

    // ---------------------------------------------------------------- ERROR HISTORICAL EXCEEDED ----------------------------------------------------------------
    public function errorHistoricalExceededToday() {
        $king = new KingMonitorModel();
        return $king->errorHistoricalExceededToday();
    }

    public function errorHistoricalExceededWeek() {
        $king = new KingMonitorModel();
        return $king->errorHistoricalExceededWeek();
    }

    public function errorHistoricalExceededMonth() {
        $king = new KingMonitorModel();
        return $king->errorHistoricalExceededMonth();
    }

    public function errorHistoricalExceededQuarter() {
        $king = new KingMonitorModel();
        return $king->errorHistoricalExceededQuarter();
    }

    public function errorHistoricalExceededYear() {
        $king = new KingMonitorModel();
        return $king->errorHistoricalExceededYear();
    }

    public function errorHistoricalExceededTotal() {
        $king = new KingMonitorModel();
        return $king->errorHistoricalExceededTotal();
    }

    // ---------------------------------------------------------------- USER HISTORICAL EXCEEDED ----------------------------------------------------------------
    public function historicalExceededToday() {
        $king = new KingMonitorModel();
        return $king->historicalExceededToday();
    }

    public function historicalExceededWeek() {
        $king = new KingMonitorModel();
        return $king->historicalExceededWeek();
    }

    public function historicalExceededMonth() {
        $king = new KingMonitorModel();
        return $king->historicalExceededMonth();
    }

    public function historicalExceededQuarter() {
        $king = new KingMonitorModel();
        return $king->historicalExceededQuarter();
    }

    public function historicalExceededYear() {
        $king = new KingMonitorModel();
        return $king->historicalExceededYear();
    }

    public function historicalExceededTotal() {
        $king = new KingMonitorModel();
        return $king->historicalExceededTotal();
    }

    // ---------------------------------------------------------------- HISTORICAL EXCEEDED ----------------------------------------------------------------
    public function requestHistoricalExceeded() {
        $king = new KingMonitorModel();
        return $king->requestHistoricalExceeded();
    }

    public function errorHistoricalExceeded() {
        $king = new KingMonitorModel();
        return $king->errorHistoricalExceeded();
    }

    public function historicalExceeded() {
        $king = new KingMonitorModel();
        return $king->historicalExceeded();
    }

    /****************************************************************** HISTORICAL ******************************************************************/
    /****************************************************************** USER HISTORICAL ******************************************************************/
    // ---------------------------------------------------------------- USER REQUEST HISTORICAL ----------------------------------------------------------------
    public function userRequestHistoricalToday($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestHistoricalToday($king_user_id);
    }

    public function userRequestHistoricalWeek($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestHistoricalWeek($king_user_id);
    }

    public function userRequestHistoricalMonth($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestHistoricalMonth($king_user_id);
    }

    public function userRequestHistoricalQuarter($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestHistoricalQuarter($king_user_id);
    }

    public function userRequestHistoricalYear($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestHistoricalYear($king_user_id);
    }

    public function userRequestHistoricalTotal($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestHistoricalTotal($king_user_id);
    }

    // ---------------------------------------------------------------- USER ERROR HISTORICAL ----------------------------------------------------------------
    public function userErrorHistoricalToday($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorHistoricalToday($king_user_id);
    }

    public function userErrorHistoricalWeek($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorHistoricalWeek($king_user_id);
    }

    public function userErrorHistoricalMonth($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorHistoricalMonth($king_user_id);
    }

    public function userErrorHistoricalQuarter($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorHistoricalQuarter($king_user_id);
    }

    public function userErrorHistoricalYear($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorHistoricalYear($king_user_id);
    }

    public function userErrorHistoricalTotal($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorHistoricalTotal($king_user_id);
    }

    // ---------------------------------------------------------------- USER HISTORICAL ----------------------------------------------------------------
    public function userHistoricalToday($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userHistoricalToday($king_user_id);
    }

    public function userHistoricalWeek($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userHistoricalWeek($king_user_id);
    }

    public function userHistoricalMonth($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userHistoricalMonth($king_user_id);
    }

    public function userHistoricalQuarter($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userHistoricalQuarter($king_user_id);
    }

    public function userHistoricalYear($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userHistoricalYear($king_user_id);
    }

    public function userHistoricalTotal($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userHistoricalTotal($king_user_id);
    }

    /****************************************************************** REQUEST HISTORICAL ******************************************************************/
    public function requestHistoricalToday() {
        $king = new KingMonitorModel();
        return $king->requestHistoricalToday();
    }

    public function requestHistoricalWeek() {
        $king = new KingMonitorModel();
        return $king->requestHistoricalWeek();
    }

    public function requestHistoricalMonth() {
        $king = new KingMonitorModel();
        return $king->requestHistoricalMonth();
    }

    public function requestHistoricalQuarter() {
        $king = new KingMonitorModel();
        return $king->requestHistoricalQuarter();
    }

    public function requestHistoricalYear() {
        $king = new KingMonitorModel();
        return $king->requestHistoricalYear();
    }

    public function requestHistoricalTotal() {
        $king = new KingMonitorModel();
        return $king->requestHistoricalTotal();
    }

    /****************************************************************** HISTORICAL ERROR ******************************************************************/
    public function errorHistoricalToday() {
        $king = new KingMonitorModel();
        return $king->errorHistoricalToday();
    }

    public function errorHistoricalWeek() {
        $king = new KingMonitorModel();
        return $king->errorHistoricalWeek();
    }

    public function errorHistoricalMonth() {
        $king = new KingMonitorModel();
        return $king->errorHistoricalMonth();
    }

    public function errorHistoricalQuarter() {
        $king = new KingMonitorModel();
        return $king->errorHistoricalQuarter();
    }

    public function errorHistoricalYear() {
        $king = new KingMonitorModel();
        return $king->errorHistoricalYear();
    }

    public function errorHistoricalTotal() {
        $king = new KingMonitorModel();
        return $king->errorHistoricalTotal();
    }

    /****************************************************************** HISTORICAL ******************************************************************/
    public function historicalToday() {
        $king = new KingMonitorModel();
        return $king->historicalToday();
    }

    public function historicalWeek() {
        $king = new KingMonitorModel();
        return $king->historicalWeek();
    }

    public function historicalMonth() {
        $king = new KingMonitorModel();
        return $king->historicalMonth();
    }

    public function historicalQuarter() {
        $king = new KingMonitorModel();
        return $king->historicalQuarter();
    }

    public function historicalYear() {
        $king = new KingMonitorModel();
        return $king->historicalYear();
    }

    public function historicalTotal() {
        $king = new KingMonitorModel();
        return $king->historicalTotal();
    }

    /****************************************************************** HISTORICAL ******************************************************************/
    public function userRequestHistorical($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userRequestHistorical($king_user_id);
    }

    public function userErrorHistorical($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userErrorHistorical($king_user_id);
    }

    public function userHistorical($king_user_id) {
        $king = new KingMonitorModel();
        return $king->userHistorical($king_user_id);
    }

    public function requestHistorical() {
        $king = new KingMonitorModel();
        return $king->requestHistorical();
    }

    public function errorHistorical() {
        $king = new KingMonitorModel();
        return $king->errorHistorical();
    }

    public function historical() {
        $king = new KingMonitorModel();
        return $king->historical();
    }

    /****************************************************************** HISTORICAL ALERT ******************************************************************/
    /****************************************************************** USER HISTORICAL ALERT ******************************************************************/
    // ---------------------------------------------------------------- USER REQUEST HISTORICAL ALERT ----------------------------------------------------------------
}