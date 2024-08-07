<?php

namespace ByCarmona141\KingMonitor\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use ByCarmona141\KingMonitor\Models\KingMonitorError;

class KingMonitorErrorController extends Controller {
    /**
     *  Mostrar los kingMonitorError
     *  @OA\Get (path="/api/v1/kingMonitorError/statistics", tags={"kingMonitorError"},
     *      @OA\Response(response=200, description="OK",
     *          @OA\MediaType(mediaType="application/vnd.api+json",
     *              @OA\Schema(
     *                  @OA\Property(type="array", property="data",
     *                      @OA\Items(type="object",
     *                          @OA\Property(property="type", type="string", example="kingMonitorError"),
     *                          @OA\Property(property="id", type="string", example="1"),
     *                          @OA\Property(type="object", property="attributes",
     *                              @OA\Property(property="king_user_id", type="number", example="1"),
     *                              @OA\Property(property="method", type="string", example="GET"),
     *                              @OA\Property(property="endpoint", type="string", example="api/v1/kingMonitorError"),
     *                              @OA\Property(property="headers", type="string", example="example"),
     *                              @OA\Property(property="ip", type="string", example="example"),
     *                              @OA\Property(property="params", type="string", example="example"),
     *                              @OA\Property(property="error", type="string", example="example"),
     *                              @OA\Property(property="message", type="string", example="example"),
     *                          ),
     *                          @OA\Property(type="object", property="links",
     *                              @OA\Property(property="self", type="string", example="http://localhost/api/v1/kingMonitorError/1"),
     *                          )
     *                      )
     *                  ),
     *                  @OA\Property(type="object", property="links",
     *                      @OA\Property(property="self", type="string", example="http://localhost/api/v1/kingMonitorError"),
     *                  )
     *              ),
     *          )
     *      )
     *  )
     */
    public function statisticsError(Request $request) {
        $kingMonitorError = new KingMonitorError();
        return $kingMonitorError->statisticsError($request, 2);
    }

    /****************************************************************** USER STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- USER STATISTICS TODAY ----------------------------------------------------------------
    public function userErrorStatisticsToday($king_user_id) {
        $king = new KingMonitorError();
        return $king->userErrorStatisticsToday($king_user_id);
    }

    public function userErrorMethodStatisticsToday($king_user_id) {
        $king = new KingMonitorError();
        return $king->userErrorMethodStatisticsToday($king_user_id);
    }

    // ---------------------------------------------------------------- USER STATISTICS WEEK ----------------------------------------------------------------
    public function userErrorStatisticsWeek($king_user_id) {
        $king = new KingMonitorError();
        return $king->userErrorStatisticsWeek($king_user_id);
    }

    public function userErrorMethodStatisticsWeek($king_user_id) {
        $king = new KingMonitorError();
        return $king->userErrorMethodStatisticsWeek($king_user_id);
    }

    // ---------------------------------------------------------------- USER STATISTICS MONTH ----------------------------------------------------------------
    public function userErrorStatisticsMonth($king_user_id) {
        $king = new KingMonitorError();
        return $king->userErrorStatisticsMonth($king_user_id);
    }

    public function userErrorMethodStatisticsMonth($king_user_id) {
        $king = new KingMonitorError();
        return $king->userErrorMethodStatisticsMonth($king_user_id);
    }

    // ---------------------------------------------------------------- USER STATISTICS QUARTER ----------------------------------------------------------------
    public function userErrorStatisticsQuarter($king_user_id) {
        $king = new KingMonitorError();
        return $king->userErrorStatisticsQuarter($king_user_id);
    }

    public function userErrorMethodStatisticsQuarter($king_user_id) {
        $king = new KingMonitorError();
        return $king->userErrorMethodStatisticsQuarter($king_user_id);
    }

    // ---------------------------------------------------------------- USER STATISTICS YEAR ----------------------------------------------------------------
    public function userErrorStatisticsYear($king_user_id) {
        $king = new KingMonitorError();
        return $king->userErrorStatisticsYear($king_user_id);
    }

    public function userErrorMethodStatisticsYear($king_user_id) {
        $king = new KingMonitorError();
        return $king->userErrorMethodStatisticsYear($king_user_id);
    }

    // ---------------------------------------------------------------- USER STATISTICS TOTAL ----------------------------------------------------------------
    public function userErrorStatisticsTotal($king_user_id) {
        $king = new KingMonitorError();
        return $king->userErrorStatisticsTotal($king_user_id);
    }

    public function userErrorMethodStatisticsTotal($king_user_id) {
        $king = new KingMonitorError();
        return $king->userErrorMethodStatisticsTotal($king_user_id);
    }

    /****************************************************************** STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS TODAY ----------------------------------------------------------------
    public function errorStatisticsToday() {
        $king = new KingMonitorError();
        return $king->errorStatisticsToday();
    }

    public function errorMethodStatisticsToday() {
        $king = new KingMonitorError();
        return $king->errorMethodStatisticsToday();
    }

    public function errorStatisticsFrequentUserToday() {
        $king = new KingMonitorError();
        return $king->errorStatisticsFrequentUserToday();
    }

    // ---------------------------------------------------------------- STATISTICS WEEK ----------------------------------------------------------------
    public function errorStatisticsWeek() {
        $king = new KingMonitorError();
        return $king->errorStatisticsWeek();
    }

    public function errorMethodStatisticsWeek() {
        $king = new KingMonitorError();
        return $king->errorMethodStatisticsWeek();
    }

    public function errorStatisticsFrequentUserWeek() {
        $king = new KingMonitorError();
        return $king->errorStatisticsFrequentUserWeek();
    }

    // ---------------------------------------------------------------- STATISTICS MONTH ----------------------------------------------------------------
    public function errorStatisticsMonth() {
        $king = new KingMonitorError();
        return $king->errorStatisticsMonth();
    }

    public function errorMethodStatisticsMonth() {
        $king = new KingMonitorError();
        return $king->errorMethodStatisticsMonth();
    }

    public function errorStatisticsFrequentUserMonth() {
        $king = new KingMonitorError();
        return $king->errorStatisticsFrequentUserMonth();
    }

    // ---------------------------------------------------------------- STATISTICS QUARTER ----------------------------------------------------------------
    public function errorStatisticsQuarter() {
        $king = new KingMonitorError();
        return $king->errorStatisticsQuarter();
    }

    public function errorMethodStatisticsQuarter() {
        $king = new KingMonitorError();
        return $king->errorMethodStatisticsQuarter();
    }

    public function errorStatisticsFrequentUserQuarter() {
        $king = new KingMonitorError();
        return $king->errorStatisticsFrequentUserQuarter();
    }

    // ---------------------------------------------------------------- STATISTICS YEAR ----------------------------------------------------------------
    public function errorStatisticsYear() {
        $king = new KingMonitorError();
        return $king->errorStatisticsYear();
    }

    public function errorMethodStatisticsYear() {
        $king = new KingMonitorError();
        return $king->errorMethodStatisticsYear();
    }

    public function errorStatisticsFrequentUserYear() {
        $king = new KingMonitorError();
        return $king->errorStatisticsFrequentUserYear();
    }

    // ---------------------------------------------------------------- STATISTICS TOTAL ----------------------------------------------------------------
    public function errorStatisticsTotal() {
        $king = new KingMonitorError();
        return $king->errorStatisticsTotal();
    }

    public function errorMethodStatisticsTotal() {
        $king = new KingMonitorError();
        return $king->errorMethodStatisticsTotal();
    }

    public function errorStatisticsFrequentUserTotal() {
        $king = new KingMonitorError();
        return $king->errorStatisticsFrequentUserTotal();
    }

    // ---------------------------------------------------------------- STATISTICS ----------------------------------------------------------------
    public function userErrorStatistics($king_user_id) {
        $king = new KingMonitorError();
        return $king->userErrorStatistics($king_user_id);
    }

    public function errorStatistics() {
        $king = new KingMonitorError();
        return $king->errorStatistics();
    }

    /****************************************************************** STATISTICS ENDPOINT ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS ENDPOINT TOTAL ----------------------------------------------------------------
    public function errorStatisticsEndpointTotal() {
        $king = new KingMonitorError();
        return $king->errorStatisticsEndpointTotal();
    }

    /****************************************************************** HISTORICAL ******************************************************************/
    // ---------------------------------------------------------------- USER HISTORICAL ----------------------------------------------------------------
    public function userErrorHistoricalToday($king_user_id) {
        $king = new KingMonitorError();
        return $king->userErrorHistoricalToday($king_user_id);
    }

    public function userErrorHistoricalWeek($king_user_id) {
        $king = new KingMonitorError();
        return $king->userErrorHistoricalWeek($king_user_id);
    }

    public function userErrorHistoricalMonth($king_user_id) {
        $king = new KingMonitorError();
        return $king->userErrorHistoricalMonth($king_user_id);
    }

    public function userErrorHistoricalQuarter($king_user_id) {
        $king = new KingMonitorError();
        return $king->userErrorHistoricalQuarter($king_user_id);
    }

    public function userErrorHistoricalYear($king_user_id) {
        $king = new KingMonitorError();
        return $king->userErrorHistoricalYear($king_user_id);
    }

    public function userErrorHistoricalTotal($king_user_id) {
        $king = new KingMonitorError();
        return $king->userErrorHistoricalTotal($king_user_id);
    }

    // ---------------------------------------------------------------- HISTORICAL ----------------------------------------------------------------
    public function errorHistoricalToday() {
        $king = new KingMonitorError();
        return $king->errorHistoricalToday();
    }

    public function errorHistoricalWeek() {
        $king = new KingMonitorError();
        return $king->errorHistoricalWeek();
    }

    public function errorHistoricalMonth() {
        $king = new KingMonitorError();
        return $king->errorHistoricalMonth();
    }

    public function errorHistoricalQuarter() {
        $king = new KingMonitorError();
        return $king->errorHistoricalQuarter();
    }

    public function errorHistoricalYear() {
        $king = new KingMonitorError();
        return $king->errorHistoricalYear();
    }

    public function errorHistoricalTotal() {
        $king = new KingMonitorError();
        return $king->errorHistoricalTotal();
    }

    // ---------------------------------------------------------------- HISTORICAL ----------------------------------------------------------------
    public function userErrorHistorical($king_user_id) {
        $king = new KingMonitorError();
        return $king->userErrorHistorical($king_user_id);
    }

    public function errorHistorical() {
        $king = new KingMonitorError();
        return $king->errorHistorical();
    }
}
