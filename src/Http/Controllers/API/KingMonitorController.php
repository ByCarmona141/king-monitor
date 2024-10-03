<?php

namespace ByCarmona141\KingMonitor\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use ByCarmona141\KingMonitor\Models\KingMonitor;

class KingMonitorController extends Controller {
    /*
    * Mandamos el booleano que nos dice sobre el limite de peticiones al dia del usuario
    */
    public function limit() {
        $kingMonitor = new KingMonitor();
        return $kingMonitor->limit();
    }

    /*********************************************** MONITOR ***********************************************/
    public function monitor(Request $request) {
        $kingMonitor = new KingMonitor();
        return $kingMonitor->monitor($request, $request->tuple);
    }

    /****************************************************************** STATISTICS USER ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS USER TODAY ----------------------------------------------------------------
    public function userStatisticsToday($king_user_id) {
        $king = new KingMonitor();
        return $king->userStatisticsToday($king_user_id);
    }

    public function userMethodStatisticsToday($king_user_id) {
        $king = new KingMonitor();
        return $king->userMethodStatisticsToday($king_user_id);
    }

    // ---------------------------------------------------------------- STATISTICS USER WEEK ----------------------------------------------------------------
    public function userStatisticsWeek($king_user_id) {
        $king = new KingMonitor();
        return $king->userStatisticsWeek($king_user_id);
    }

    public function userMethodStatisticsWeek($king_user_id) {
        $king = new KingMonitor();
        return $king->userMethodStatisticsWeek($king_user_id);
    }

    // ---------------------------------------------------------------- STATISTICS USER MONTH ----------------------------------------------------------------
    public function userStatisticsMonth($king_user_id) {
        $king = new KingMonitor();
        return $king->userStatisticsMonth($king_user_id);
    }

    public function userMethodStatisticsMonth($king_user_id) {
        $king = new KingMonitor();
        return $king->userMethodStatisticsMonth($king_user_id);
    }

    // ---------------------------------------------------------------- STATISTICS USER QUARTER ----------------------------------------------------------------
    public function userStatisticsQuarter($king_user_id) {
        $king = new KingMonitor();
        return $king->userStatisticsQuarter($king_user_id);
    }

    public function userMethodStatisticsQuarter($king_user_id) {
        $king = new KingMonitor();
        return $king->userMethodStatisticsQuarter($king_user_id);
    }

    // ---------------------------------------------------------------- STATISTICS USER YEAR ----------------------------------------------------------------
    public function userStatisticsYear($king_user_id) {
        $king = new KingMonitor();
        return $king->userStatisticsYear($king_user_id);
    }

    public function userMethodStatisticsYear($king_user_id) {
        $king = new KingMonitor();
        return $king->userMethodStatisticsYear($king_user_id);
    }

    // ---------------------------------------------------------------- STATISTICS USER TOTAL ----------------------------------------------------------------
    public function userStatisticsTotal($king_user_id) {
        $king = new KingMonitor();
        return $king->userStatisticsTotal($king_user_id);
    }

    public function userMethodStatisticsTotal($king_user_id) {
        $king = new KingMonitor();
        return $king->userMethodStatisticsTotal($king_user_id);
    }

    /****************************************************************** STATISTICS USER REQUEST ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS USER TODAY REQUEST ----------------------------------------------------------------
    public function userRequestStatisticsToday($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestStatisticsToday($king_user_id);
    }

    public function userRequestMethodStatisticsToday($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestMethodStatisticsToday($king_user_id);
    }

    // ---------------------------------------------------------------- STATISTICS USER WEEK REQUEST ----------------------------------------------------------------
    public function userRequestStatisticsWeek($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestStatisticsWeek($king_user_id);
    }

    public function userRequestMethodStatisticsWeek($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestMethodStatisticsWeek($king_user_id);
    }

    // ---------------------------------------------------------------- STATISTICS USER MONTH REQUEST ----------------------------------------------------------------
    public function userRequestStatisticsMonth($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestStatisticsMonth($king_user_id);
    }

    public function userRequestMethodStatisticsMonth($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestMethodStatisticsMonth($king_user_id);
    }

    // ---------------------------------------------------------------- STATISTICS USER QUARTER REQUEST ----------------------------------------------------------------
    public function userRequestStatisticsQuarter($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestStatisticsQuarter($king_user_id);
    }

    public function userRequestMethodStatisticsQuarter($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestMethodStatisticsQuarter($king_user_id);
    }

    // ---------------------------------------------------------------- STATISTICS USER YEAR REQUEST ----------------------------------------------------------------
    public function userRequestStatisticsYear($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestStatisticsYear($king_user_id);
    }

    public function userRequestMethodStatisticsYear($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestMethodStatisticsYear($king_user_id);
    }

    // ---------------------------------------------------------------- STATISTICS USER TOTAL REQUEST ----------------------------------------------------------------
    public function userRequestStatisticsTotal($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestStatisticsTotal($king_user_id);
    }

    public function userRequestMethodStatisticsTotal($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestMethodStatisticsTotal($king_user_id);
    }

    /****************************************************************** STATISTICS REQUEST ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS TODAY REQUEST ----------------------------------------------------------------
    public function requestStatisticsToday() {
        $king = new KingMonitor();
        return $king->requestStatisticsToday();
    }

    public function requestMethodStatisticsToday() {
        $king = new KingMonitor();
        return $king->requestMethodStatisticsToday();
    }

    public function requestStatisticsFrequentUserToday() {
        $king = new KingMonitor();
        return $king->requestStatisticsFrequentUserToday();
    }

    // ---------------------------------------------------------------- STATISTICS WEEK REQUEST ----------------------------------------------------------------
    public function requestStatisticsWeek() {
        $king = new KingMonitor();
        return $king->requestStatisticsWeek();
    }

    public function requestMethodStatisticsWeek() {
        $king = new KingMonitor();
        return $king->requestMethodStatisticsWeek();
    }

    public function requestStatisticsFrequentUserWeek() {
        $king = new KingMonitor();
        return $king->requestStatisticsFrequentUserWeek();
    }

    // ---------------------------------------------------------------- STATISTICS MONTH REQUEST ----------------------------------------------------------------
    public function requestStatisticsMonth() {
        $king = new KingMonitor();
        return $king->requestStatisticsMonth();
    }

    public function requestMethodStatisticsMonth() {
        $king = new KingMonitor();
        return $king->requestMethodStatisticsMonth();
    }

    public function requestStatisticsFrequentUserMonth() {
        $king = new KingMonitor();
        return $king->requestStatisticsFrequentUserMonth();
    }

    // ---------------------------------------------------------------- STATISTICS QUARTER REQUEST ----------------------------------------------------------------
    public function requestStatisticsQuarter() {
        $king = new KingMonitor();
        return $king->requestStatisticsQuarter();
    }

    public function requestMethodStatisticsQuarter() {
        $king = new KingMonitor();
        return $king->requestMethodStatisticsQuarter();
    }

    public function requestStatisticsFrequentUserQuarter() {
        $king = new KingMonitor();
        return $king->requestStatisticsFrequentUserQuarter();
    }

    // ---------------------------------------------------------------- STATISTICS YEAR REQUEST ----------------------------------------------------------------
    public function requestStatisticsYear() {
        $king = new KingMonitor();
        return $king->requestStatisticsYear();
    }

    public function requestMethodStatisticsYear() {
        $king = new KingMonitor();
        return $king->requestMethodStatisticsYear();
    }

    public function requestStatisticsFrequentUserYear() {
        $king = new KingMonitor();
        return $king->requestStatisticsFrequentUserYear();
    }

    // ---------------------------------------------------------------- STATISTICS TOTAL REQUEST ----------------------------------------------------------------

    /**
     *  Mostrar los kingMonitor
     *  @OA\Get (path="/api/v1/kingMonitor/statisticsTotal", tags={"kingMonitor"},
     *      @OA\Response(response=200, description="OK",
     *          @OA\MediaType(mediaType="application/vnd.api+json",
     *              @OA\Schema(
     *                  @OA\Property(property="totalRequest", type="number", example="1"),
     *                  @OA\Property(type="object", property="method",
     *                      @OA\Property(property="mostCommon", type="array",
     *                          @OA\Items(anyOf={@OA\Schema(type="string")})
     *                      ),
     *                      @OA\Property(property="GET", type="number", example="1"),
     *                      @OA\Property(property="POST", type="number", example="1"),
     *                      @OA\Property(property="PUT", type="number", example="1"),
     *                      @OA\Property(property="PATCH", type="number", example="1"),
     *                      @OA\Property(property="DELETE", type="number", example="1"),
     *                  ),
     *                  @OA\Property(property="userRequest", type="array",
     *                      @OA\Items(anyOf={@OA\Schema(type="number")})
     *                  ),
     *              ),
     *          )
     *      )
     *  )
     */
    public function requestStatisticsTotal() {
        $king = new KingMonitor();
        return $king->requestStatisticsTotal();
    }

    public function requestMethodStatisticsTotal() {
        $king = new KingMonitor();
        return $king->requestMethodStatisticsTotal();
    }

    public function requestStatisticsFrequentUserTotal() {
        $king = new KingMonitor();
        return $king->requestStatisticsFrequentUserTotal();
    }

    /****************************************************************** STATISTICS ERRORS USER ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS ERRORS USER TODAY ----------------------------------------------------------------
    public function userErrorStatisticsToday($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorStatisticsToday($king_user_id);
    }

    public function userErrorMethodStatisticsToday($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorMethodStatisticsToday($king_user_id);
    }

    // ---------------------------------------------------------------- STATISTICS ERRORS USER WEEK ----------------------------------------------------------------
    public function userErrorStatisticsWeek($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorStatisticsWeek($king_user_id);
    }

    public function userErrorMethodStatisticsWeek($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorMethodStatisticsWeek($king_user_id);
    }

    // ---------------------------------------------------------------- STATISTICS ERRORS USER MONTH ----------------------------------------------------------------
    public function userErrorStatisticsMonth($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorStatisticsMonth($king_user_id);
    }

    public function userErrorMethodStatisticsMonth($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorMethodStatisticsMonth($king_user_id);
    }

    // ---------------------------------------------------------------- STATISTICS ERRORS USER QUARTER ----------------------------------------------------------------
    public function userErrorStatisticsQuarter($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorStatisticsQuarter($king_user_id);
    }

    public function userErrorMethodStatisticsQuarter($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorMethodStatisticsQuarter($king_user_id);
    }

    // ---------------------------------------------------------------- STATISTICS ERRORS USER YEAR ----------------------------------------------------------------
    public function userErrorStatisticsYear($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorStatisticsYear($king_user_id);
    }

    public function userErrorMethodStatisticsYear($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorMethodStatisticsYear($king_user_id);
    }

    // ---------------------------------------------------------------- STATISTICS ERRORS USER TOTAL ----------------------------------------------------------------
    public function userErrorStatisticsTotal($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorStatisticsTotal($king_user_id);
    }

    public function userErrorMethodStatisticsTotal($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorMethodStatisticsTotal($king_user_id);
    }

    /****************************************************************** STATISTICS ERRORS ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS ERRORS TODAY ----------------------------------------------------------------
    public function errorStatisticsToday() {
        $king = new KingMonitor();
        return $king->errorStatisticsToday();
    }

    public function errorMethodStatisticsToday() {
        $king = new KingMonitor();
        return $king->errorMethodStatisticsToday();
    }

    public function errorStatisticsFrequentUserToday() {
        $king = new KingMonitor();
        return $king->errorStatisticsFrequentUserToday();
    }

    // ---------------------------------------------------------------- STATISTICS ERRORS WEEK ----------------------------------------------------------------
    public function errorStatisticsWeek() {
        $king = new KingMonitor();
        return $king->errorStatisticsWeek();
    }

    public function errorMethodStatisticsWeek() {
        $king = new KingMonitor();
        return $king->errorMethodStatisticsWeek();
    }

    public function errorStatisticsFrequentUserWeek() {
        $king = new KingMonitor();
        return $king->errorStatisticsFrequentUserWeek();
    }

    // ---------------------------------------------------------------- STATISTICS ERRORS MONTH ----------------------------------------------------------------
    public function errorStatisticsMonth() {
        $king = new KingMonitor();
        return $king->errorStatisticsMonth();
    }

    public function errorMethodStatisticsMonth() {
        $king = new KingMonitor();
        return $king->errorMethodStatisticsMonth();
    }

    public function errorStatisticsFrequentUserMonth() {
        $king = new KingMonitor();
        return $king->errorStatisticsFrequentUserMonth();
    }

    // ---------------------------------------------------------------- STATISTICS ERRORS QUARTER ----------------------------------------------------------------
    public function errorStatisticsQuarter() {
        $king = new KingMonitor();
        return $king->errorStatisticsQuarter();
    }

    public function errorMethodStatisticsQuarter() {
        $king = new KingMonitor();
        return $king->errorMethodStatisticsQuarter();
    }

    public function errorStatisticsFrequentUserQuarter() {
        $king = new KingMonitor();
        return $king->errorStatisticsFrequentUserQuarter();
    }

    // ---------------------------------------------------------------- STATISTICS ERRORS YEAR ----------------------------------------------------------------
    public function errorStatisticsYear() {
        $king = new KingMonitor();
        return $king->errorStatisticsYear();
    }

    public function errorMethodStatisticsYear() {
        $king = new KingMonitor();
        return $king->errorMethodStatisticsYear();
    }

    public function errorStatisticsFrequentUserYear() {
        $king = new KingMonitor();
        return $king->errorStatisticsFrequentUserYear();
    }

    // ---------------------------------------------------------------- STATISTICS ERRORS TOTAL ----------------------------------------------------------------
    public function errorStatisticsTotal() {
        $king = new KingMonitor();
        return $king->errorStatisticsTotal();
    }

    public function errorMethodStatisticsTotal() {
        $king = new KingMonitor();
        return $king->errorMethodStatisticsTotal();
    }

    public function errorStatisticsFrequentUserTotal() {
        $king = new KingMonitor();
        return $king->errorStatisticsFrequentUserTotal();
    }

    // ---------------------------------------------------------------- STATISTICS ENDPOINTS ----------------------------------------------------------------
    public function requestStatisticsEndpointTotal() {
        $king = new KingMonitor();
        return $king->requestStatisticsEndpointTotal();
    }

    public function errorStatisticsEndpointTotal() {
        $king = new KingMonitor();
        return $king->errorStatisticsEndpointTotal();
    }

    /****************************************************************** STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS TODAY ----------------------------------------------------------------
    public function statisticsToday() {
        $king = new KingMonitor();
        return $king->statisticsToday();
    }

    public function methodStatisticsToday() {
        $king = new KingMonitor();
        return $king->methodStatisticsToday();
    }

    public function statisticsFrequentUserToday() {
        $king = new KingMonitor();
        return $king->statisticsFrequentUserToday();
    }

    // ---------------------------------------------------------------- STATISTICS WEEK ----------------------------------------------------------------
    public function statisticsWeek() {
        $king = new KingMonitor();
        return $king->statisticsWeek();
    }

    public function methodStatisticsWeek() {
        $king = new KingMonitor();
        return $king->methodStatisticsWeek();
    }

    public function statisticsFrequentUserWeek() {
        $king = new KingMonitor();
        return $king->statisticsFrequentUserWeek();
    }

    // ---------------------------------------------------------------- STATISTICS MONTH ----------------------------------------------------------------
    public function statisticsMonth() {
        $king = new KingMonitor();
        return $king->statisticsMonth();
    }

    public function methodStatisticsMonth() {
        $king = new KingMonitor();
        return $king->methodStatisticsMonth();
    }

    public function statisticsFrequentUserMonth() {
        $king = new KingMonitor();
        return $king->statisticsFrequentUserMonth();
    }

    // ---------------------------------------------------------------- STATISTICS QUARTER ----------------------------------------------------------------
    public function statisticsQuarter() {
        $king = new KingMonitor();
        return $king->statisticsQuarter();
    }

    public function methodStatisticsQuarter() {
        $king = new KingMonitor();
        return $king->methodStatisticsQuarter();
    }

    public function statisticsFrequentUserQuarter() {
        $king = new KingMonitor();
        return $king->statisticsFrequentUserQuarter();
    }

    // ---------------------------------------------------------------- STATISTICS YEAR ----------------------------------------------------------------
    public function statisticsYear() {
        $king = new KingMonitor();
        return $king->statisticsYear();
    }

    public function methodStatisticsYear() {
        $king = new KingMonitor();
        return $king->methodStatisticsYear();
    }

    public function statisticsFrequentUserYear() {
        $king = new KingMonitor();
        return $king->statisticsFrequentUserYear();
    }

    // ---------------------------------------------------------------- STATISTICS TOTAL ----------------------------------------------------------------

    /**
     *  Mostrar los kingMonitor
     *  @OA\Get (path="/api/v1/kingMonitor/statisticsTotal", tags={"kingMonitor"},
     *      @OA\Response(response=200, description="OK",
     *          @OA\MediaType(mediaType="application/vnd.api+json",
     *              @OA\Schema(
     *                  @OA\Property(property="totalRequest", type="number", example="1"),
     *                  @OA\Property(type="object", property="method",
     *                      @OA\Property(property="mostCommon", type="array",
     *                          @OA\Items(anyOf={@OA\Schema(type="string")})
     *                      ),
     *                      @OA\Property(property="GET", type="number", example="1"),
     *                      @OA\Property(property="POST", type="number", example="1"),
     *                      @OA\Property(property="PUT", type="number", example="1"),
     *                      @OA\Property(property="PATCH", type="number", example="1"),
     *                      @OA\Property(property="DELETE", type="number", example="1"),
     *                  ),
     *                  @OA\Property(property="userRequest", type="array",
     *                      @OA\Items(anyOf={@OA\Schema(type="number")})
     *                  ),
     *              ),
     *          )
     *      )
     *  )
     */
    public function statisticsTotal() {
        $king = new KingMonitor();
        return $king->statisticsTotal();
    }

    public function methodStatisticsTotal() {
        $king = new KingMonitor();
        return $king->methodStatisticsTotal();
    }

    public function statisticsFrequentUserTotal() {
        $king = new KingMonitor();
        return $king->statisticsFrequentUserTotal();
    }

    /*********************************************** STATISTICS ***********************************************/

    /**
     *  Mostrar los kingMonitor
     *  @OA\Get (path="/api/v1/kingMonitor/statistics", tags={"kingMonitor"},
     *      @OA\Response(response=200, description="OK",
     *          @OA\MediaType(mediaType="application/vnd.api+json",
     *              @OA\Schema(
     *                  @OA\Property(type="array", property="data",
     *                      @OA\Items(type="object",
     *                          @OA\Property(property="type", type="string", example="kingMonitor"),
     *                          @OA\Property(property="id", type="string", example="1"),
     *                          @OA\Property(type="object", property="attributes",
     *                              @OA\Property(property="king_user_id", type="number", example="1"),
     *                              @OA\Property(property="tuple", type="string", example="1"),
     *                              @OA\Property(property="method", type="string", example="GET"),
     *                              @OA\Property(property="endpoint", type="string", example="api/v1/kingMonitor"),
     *                              @OA\Property(property="headers", type="string", example="example"),
     *                              @OA\Property(property="ip", type="string", example="example"),
     *                              @OA\Property(property="params", type="string", example="example"),
     *                              @OA\Property(property="data", type="string", example="example"),
     *                              @OA\Property(property="response", type="string", example="example"),
     *                              @OA\Property(property="error", type="string", example="example"),
     *                          ),
     *                          @OA\Property(type="object", property="links",
     *                              @OA\Property(property="self", type="string", example="http://localhost/api/v1/kingMonitor/1"),
     *                          )
     *                      )
     *                  ),
     *                  @OA\Property(type="object", property="links",
     *                      @OA\Property(property="self", type="string", example="http://localhost/api/v1/kingMonitor"),
     *                  )
     *              ),
     *          )
     *      )
     *  )
     */
    public function statistics() {
        $king = new KingMonitor();
        return $king->statistics();
    }

    public function userStatistics($king_user_id) {
        $king = new KingMonitor();
        return $king->userStatistics($king_user_id);
    }

    public function userRequestStatistics($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestStatistics($king_user_id);
    }

    public function errorStatistics() {
        $king = new KingMonitor();
        return $king->errorStatistics();
    }

    public function userErrorStatistics($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorStatistics($king_user_id);
    }

    public function requestStatistics() {
        $king = new KingMonitor();
        return $king->requestStatistics();
    }

    /****************************************************************** USER STATISTICS EXCEEDED ******************************************************************/
    /****************************************************************** USER REQUEST STATISTICS EXCEEDED ******************************************************************/
    public function userRequestStatisticsExceededToday($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestStatisticsExceededToday($king_user_id);
    }

    public function userRequestStatisticsExceededWeek($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestStatisticsExceededWeek($king_user_id);
    }

    public function userRequestStatisticsExceededMonth($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestStatisticsExceededMonth($king_user_id);
    }

    public function userRequestStatisticsExceededQuarter($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestStatisticsExceededQuarter($king_user_id);
    }

    public function userRequestStatisticsExceededYear($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestStatisticsExceededYear($king_user_id);
    }

    public function userRequestStatisticsExceededTotal($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestStatisticsExceededTotal($king_user_id);
    }

    /****************************************************************** USER ERROR STATISTICS EXCEEDED ******************************************************************/
    public function userErrorStatisticsExceededToday($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorStatisticsExceededToday($king_user_id);
    }

    public function userErrorStatisticsExceededWeek($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorStatisticsExceededWeek($king_user_id);
    }

    public function userErrorStatisticsExceededMonth($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorStatisticsExceededMonth($king_user_id);
    }

    public function userErrorStatisticsExceededQuarter($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorStatisticsExceededQuarter($king_user_id);
    }

    public function userErrorStatisticsExceededYear($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorStatisticsExceededYear($king_user_id);
    }

    public function userErrorStatisticsExceededTotal($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorStatisticsExceededTotal($king_user_id);
    }

    /****************************************************************** USER STATISTICS EXCEEDED ******************************************************************/
    public function userStatisticsExceededToday($king_user_id) {
        $king = new KingMonitor();
        return $king->userStatisticsExceededToday($king_user_id);
    }

    public function userStatisticsExceededWeek($king_user_id) {
        $king = new KingMonitor();
        return $king->userStatisticsExceededWeek($king_user_id);
    }

    public function userStatisticsExceededMonth($king_user_id) {
        $king = new KingMonitor();
        return $king->userStatisticsExceededMonth($king_user_id);
    }

    public function userStatisticsExceededQuarter($king_user_id) {
        $king = new KingMonitor();
        return $king->userStatisticsExceededQuarter($king_user_id);
    }

    public function userStatisticsExceededYear($king_user_id) {
        $king = new KingMonitor();
        return $king->userStatisticsExceededYear($king_user_id);
    }

    public function userStatisticsExceededTotal($king_user_id) {
        $king = new KingMonitor();
        return $king->userStatisticsExceededTotal($king_user_id);
    }

    /****************************************************************** USER STATISTICS EXCEEDED ******************************************************************/
    public function userRequestStatisticsExceeded($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestStatisticsExceeded($king_user_id);
    }

    public function userErrorStatisticsExceeded($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorStatisticsExceeded($king_user_id);
    }

    public function userStatisticsExceeded($king_user_id) {
        $king = new KingMonitor();
        return $king->userStatisticsExceeded($king_user_id);
    }

    /****************************************************************** STATISTICS EXCEEDED ******************************************************************/
    /****************************************************************** STATISTICS EXCEEDED REQUEST ******************************************************************/
    public function requestStatisticsExceededToday() {
        $king = new KingMonitor();
        return $king->requestStatisticsExceededToday();
    }

    public function requestStatisticsExceededWeek() {
        $king = new KingMonitor();
        return $king->requestStatisticsExceededWeek();
    }

    public function requestStatisticsExceededMonth() {
        $king = new KingMonitor();
        return $king->requestStatisticsExceededMonth();
    }

    public function requestStatisticsExceededQuarter() {
        $king = new KingMonitor();
        return $king->requestStatisticsExceededQuarter();
    }

    public function requestStatisticsExceededYear() {
        $king = new KingMonitor();
        return $king->requestStatisticsExceededYear();
    }

    public function requestStatisticsExceededTotal() {
        $king = new KingMonitor();
        return $king->requestStatisticsExceededTotal();
    }

    /****************************************************************** ERROR STATISTICS EXCEEDED ******************************************************************/
    public function errorStatisticsExceededToday() {
        $king = new KingMonitor();
        return $king->errorStatisticsExceededToday();
    }

    public function errorStatisticsExceededWeek() {
        $king = new KingMonitor();
        return $king->errorStatisticsExceededWeek();
    }

    public function errorStatisticsExceededMonth() {
        $king = new KingMonitor();
        return $king->errorStatisticsExceededMonth();
    }

    public function errorStatisticsExceededQuarter() {
        $king = new KingMonitor();
        return $king->errorStatisticsExceededQuarter();
    }

    public function errorStatisticsExceededYear() {
        $king = new KingMonitor();
        return $king->errorStatisticsExceededYear();
    }

    public function errorStatisticsExceededTotal() {
        $king = new KingMonitor();
        return $king->errorStatisticsExceededTotal();
    }

    /****************************************************************** STATISTICS EXCEEDED ******************************************************************/
    public function statisticsExceededToday() {
        $king = new KingMonitor();
        return $king->statisticsExceededToday();
    }

    public function statisticsExceededWeek() {
        $king = new KingMonitor();
        return $king->statisticsExceededWeek();
    }

    public function statisticsExceededMonth() {
        $king = new KingMonitor();
        return $king->statisticsExceededMonth();
    }

    public function statisticsExceededQuarter() {
        $king = new KingMonitor();
        return $king->statisticsExceededQuarter();
    }

    public function statisticsExceededYear() {
        $king = new KingMonitor();
        return $king->statisticsExceededYear();
    }

    public function statisticsExceededTotal() {
        $king = new KingMonitor();
        return $king->statisticsExceededTotal();
    }

    /****************************************************************** STATISTICS EXCEEDED ******************************************************************/
    public function requestStatisticsExceeded() {
        $king = new KingMonitor();
        return $king->requestStatisticsExceeded();
    }

    public function errorStatisticsExceeded() {
        $king = new KingMonitor();
        return $king->errorStatisticsExceeded();
    }

    public function statisticsExceeded() {
        $king = new KingMonitor();
        return $king->statisticsExceeded();
    }

    /****************************************************************** HISTORICAL ******************************************************************/
    /****************************************************************** USER HISTORICAL ******************************************************************/
    // ---------------------------------------------------------------- USER HISTORICAL REQUEST ----------------------------------------------------------------
    public function userRequestHistoricalToday($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestHistoricalToday($king_user_id);
    }

    public function userRequestHistoricalWeek($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestHistoricalWeek($king_user_id);
    }

    public function userRequestHistoricalMonth($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestHistoricalMonth($king_user_id);
    }

    public function userRequestHistoricalQuarter($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestHistoricalQuarter($king_user_id);
    }

    public function userRequestHistoricalYear($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestHistoricalYear($king_user_id);
    }

    public function userRequestHistoricalTotal($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestHistoricalTotal($king_user_id);
    }

    // ---------------------------------------------------------------- USER HISTORICAL ERROR ----------------------------------------------------------------
    public function userErrorHistoricalToday($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorHistoricalToday($king_user_id);
    }

    public function userErrorHistoricalWeek($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorHistoricalWeek($king_user_id);
    }

    public function userErrorHistoricalMonth($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorHistoricalMonth($king_user_id);
    }

    public function userErrorHistoricalQuarter($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorHistoricalQuarter($king_user_id);
    }

    public function userErrorHistoricalYear($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorHistoricalYear($king_user_id);
    }

    public function userErrorHistoricalTotal($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorHistoricalTotal($king_user_id);
    }

    // ---------------------------------------------------------------- USER HISTORICAL ----------------------------------------------------------------
    public function userHistoricalToday($king_user_id) {
        $king = new KingMonitor();
        return $king->userHistoricalToday($king_user_id);
    }

    public function userHistoricalWeek($king_user_id) {
        $king = new KingMonitor();
        return $king->userHistoricalWeek($king_user_id);
    }

    public function userHistoricalMonth($king_user_id) {
        $king = new KingMonitor();
        return $king->userHistoricalMonth($king_user_id);
    }

    public function userHistoricalQuarter($king_user_id) {
        $king = new KingMonitor();
        return $king->userHistoricalQuarter($king_user_id);
    }

    public function userHistoricalYear($king_user_id) {
        $king = new KingMonitor();
        return $king->userHistoricalYear($king_user_id);
    }

    public function userHistoricalTotal($king_user_id) {
        $king = new KingMonitor();
        return $king->userHistoricalTotal($king_user_id);
    }

    /****************************************************************** HISTORICAL REQUEST ******************************************************************/
    public function requestHistoricalToday() {
        $king = new KingMonitor();
        return $king->requestHistoricalToday();
    }

    public function requestHistoricalWeek() {
        $king = new KingMonitor();
        return $king->requestHistoricalWeek();
    }

    public function requestHistoricalMonth() {
        $king = new KingMonitor();
        return $king->requestHistoricalMonth();
    }

    public function requestHistoricalQuarter() {
        $king = new KingMonitor();
        return $king->requestHistoricalQuarter();
    }

    public function requestHistoricalYear() {
        $king = new KingMonitor();
        return $king->requestHistoricalYear();
    }

    public function requestHistoricalTotal() {
        $king = new KingMonitor();
        return $king->requestHistoricalTotal();
    }

    /****************************************************************** HISTORICAL ERROR ******************************************************************/
    public function errorHistoricalToday() {
        $king = new KingMonitor();
        return $king->errorHistoricalToday();
    }

    public function errorHistoricalWeek() {
        $king = new KingMonitor();
        return $king->errorHistoricalWeek();
    }

    public function errorHistoricalMonth() {
        $king = new KingMonitor();
        return $king->errorHistoricalMonth();
    }

    public function errorHistoricalQuarter() {
        $king = new KingMonitor();
        return $king->errorHistoricalQuarter();
    }

    public function errorHistoricalYear() {
        $king = new KingMonitor();
        return $king->errorHistoricalYear();
    }

    public function errorHistoricalTotal() {
        $king = new KingMonitor();
        return $king->errorHistoricalTotal();
    }

    /****************************************************************** HISTORICAL ******************************************************************/
    public function historicalToday() {
        $king = new KingMonitor();
        return $king->historicalToday();
    }

    public function historicalWeek() {
        $king = new KingMonitor();
        return $king->historicalWeek();
    }

    public function historicalMonth() {
        $king = new KingMonitor();
        return $king->historicalMonth();
    }

    public function historicalQuarter() {
        $king = new KingMonitor();
        return $king->historicalQuarter();
    }

    public function historicalYear() {
        $king = new KingMonitor();
        return $king->historicalYear();
    }

    public function historicalTotal() {
        $king = new KingMonitor();
        return $king->historicalTotal();
    }

    /****************************************************************** HISTORICAL ******************************************************************/
    public function userRequestHistorical($king_user_id) {
        $king = new KingMonitor();
        return $king->userRequestHistorical($king_user_id);
    }

    public function userErrorHistorical($king_user_id) {
        $king = new KingMonitor();
        return $king->userErrorHistorical($king_user_id);
    }

    public function userHistorical($king_user_id) {
        $king = new KingMonitor();
        return $king->userHistorical($king_user_id);
    }

    public function requestHistorical() {
        $king = new KingMonitor();
        return $king->requestHistorical();
    }

    public function errorHistorical() {
        $king = new KingMonitor();
        return $king->errorHistorical();
    }

    public function historical() {
        $king = new KingMonitor();
        return $king->historical();
    }

    /****************************************************************** AVG REQUEST ******************************************************************/
    public function averageRequestTimeToday() {
        $king = new KingMonitor();
        return $king->averageRequestTimeToday();
    }

    public function averageRequestTimeWeek() {
        $king = new KingMonitor();
        return $king->averageRequestTimeWeek();
    }

    public function averageRequestTimeMonth() {
        $king = new KingMonitor();
        return $king->averageRequestTimeMonth();
    }

    public function averageRequestTimeQuarter() {
        $king = new KingMonitor();
        return $king->averageRequestTimeQuarter();
    }

    public function averageRequestTimeYear() {
        $king = new KingMonitor();
        return $king->averageRequestTimeYear();
    }

    public function averageRequestTimeTotal() {
        $king = new KingMonitor();
        return $king->averageRequestTimeTotal();
    }

    /****************************************************************** AVG ERROR ******************************************************************/
    public function averageErrorTimeToday() {
        $king = new KingMonitor();
        return $king->averageErrorTimeToday();
    }

    public function averageErrorTimeWeek() {
        $king = new KingMonitor();
        return $king->averageErrorTimeWeek();
    }

    public function averageErrorTimeMonth() {
        $king = new KingMonitor();
        return $king->averageErrorTimeMonth();
    }

    public function averageErrorTimeQuarter() {
        $king = new KingMonitor();
        return $king->averageErrorTimeQuarter();
    }

    public function averageErrorTimeYear() {
        $king = new KingMonitor();
        return $king->averageErrorTimeYear();
    }

    public function averageErrorTimeTotal() {
        $king = new KingMonitor();
        return $king->averageErrorTimeTotal();
    }

    /****************************************************************** AVG ******************************************************************/
    public function averageTimeToday() {
        $king = new KingMonitor();
        return $king->averageTimeToday();
    }

    public function averageTimeWeek() {
        $king = new KingMonitor();
        return $king->averageTimeWeek();
    }

    public function averageTimeMonth() {
        $king = new KingMonitor();
        return $king->averageTimeMonth();
    }

    public function averageTimeQuarter() {
        $king = new KingMonitor();
        return $king->averageTimeQuarter();
    }

    public function averageTimeYear() {
        $king = new KingMonitor();
        return $king->averageTimeYear();
    }

    public function averageTimeTotal() {
        $king = new KingMonitor();
        return $king->averageTimeTotal();
    }
}
