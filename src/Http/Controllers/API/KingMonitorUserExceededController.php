<?php

namespace ByCarmona141\KingMonitor\Http\Controllers\API;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use ByCarmona141\KingMonitor\Models\KingMonitorUserExceeded;

class KingMonitorUserExceededController extends Controller {
    /*
    * Mandamos el booleano que nos dice si el usuario ya esta registrado
    */
    public function limit() {
        $king = new KingMonitorUserExceeded();
        return $king->limit();
    }

    /****************************************************************** USER ******************************************************************/
    // ---------------------------------------------------------------- USER REQUEST EXCEEDED TODAY ----------------------------------------------------------------

    /*
    * Funcion para obtener los usuarios que superaron el limite de peticiones del dia
    */
    public function userExceededToday() {
        $king = new KingMonitorUserExceeded();
        return $king->userExceededToday();
    }

    // ---------------------------------------------------------------- USER REQUEST EXCEEDED WEEK ----------------------------------------------------------------

    /*
    * Funcion para obtener los usuarios que superaron el limite de peticiones de la semana
    */
    public function userExceededWeek() {
        $king = new KingMonitorUserExceeded();
        return $king->userExceededWeek();
    }

    // ---------------------------------------------------------------- USER REQUEST EXCEEDED MONTH ----------------------------------------------------------------

    /*
    * Funcion para obtener los usuarios que superaron el limite de peticiones del mes
    */
    public function userExceededMonth() {
        $king = new KingMonitorUserExceeded();
        return $king->userExceededMonth();
    }

    // ---------------------------------------------------------------- USER REQUEST EXCEEDED QUARTER ----------------------------------------------------------------

    /*
    * Funcion para obtener los usuarios que superaron el limite de peticiones del trimestre
    */
    public function userExceededQuarter() {
        $king = new KingMonitorUserExceeded();
        return $king->userExceededQuarter();
    }

    // ---------------------------------------------------------------- USER REQUEST EXCEEDED YEAR ----------------------------------------------------------------

    /*
    * Funcion para obtener los usuarios que superaron el limite de peticiones del año
    */
    public function userExceededYear() {
        $king = new KingMonitorUserExceeded();
        return $king->userExceededYear();
    }

    // ---------------------------------------------------------------- USER REQUEST EXCEEDED TOTAL ----------------------------------------------------------------

    /*
    * Funcion para obtener los usuarios que superaron el limite de peticiones de todos los tiempos
    */
    public function userExceededTotal() {
        $king = new KingMonitorUserExceeded();
        return $king->userExceededTotal();
    }

    /****************************************************************** TOKEN ******************************************************************/
    // ---------------------------------------------------------------- TOKEN REQUEST EXCEEDED TODAY ----------------------------------------------------------------

    /*
    * Funcion para obtener los tokens que superaron el limite de peticiones del dia
    */
    public function tokenExceededToday() {
        $king = new KingMonitorUserExceeded();
        return $king->tokenExceededToday();
    }

    // ---------------------------------------------------------------- TOKEN REQUEST EXCEEDED WEEK ----------------------------------------------------------------

    /*
    * Funcion para obtener los tokens que superaron el limite de peticiones de la semana
    */
    public function tokenExceededWeek() {
        $king = new KingMonitorUserExceeded();
        return $king->tokenExceededWeek();
    }

    // ---------------------------------------------------------------- TOKEN REQUEST EXCEEDED MONTH ----------------------------------------------------------------

    /*
    * Funcion para obtener los tokens que superaron el limite de peticiones del mes
    */
    public function tokenExceededMonth() {
        $king = new KingMonitorUserExceeded();
        return $king->tokenExceededMonth();
    }

    // ---------------------------------------------------------------- TOKEN REQUEST EXCEEDED QUARTER ----------------------------------------------------------------

    /*
    * Funcion para obtener los tokens que superaron el limite de peticiones del trimestre
    */
    public function tokenExceededQuarter() {
        $king = new KingMonitorUserExceeded();
        return $king->tokenExceededQuarter();
    }

    // ---------------------------------------------------------------- TOKEN REQUEST EXCEEDED YEAR ----------------------------------------------------------------

    /*
    * Funcion para obtener los tokens que superaron el limite de peticiones del año
    */
    public function tokenExceededYear() {
        $king = new KingMonitorUserExceeded();
        return $king->tokenExceededYear();
    }

    // ---------------------------------------------------------------- TOKEN REQUEST EXCEEDED TOTAL ----------------------------------------------------------------

    /*
    * Funcion para obtener los tokens que superaron el limite de peticiones de todos los tiempos
    */
    public function tokenExceededTotal() {
        $king = new KingMonitorUserExceeded();
        return $king->tokenExceededTotal();
    }

    /****************************************************************** IP ******************************************************************/
    // ---------------------------------------------------------------- IP REQUEST EXCEEDED TODAY ----------------------------------------------------------------

    /*
    * Funcion para obtener las IP que superaron el limite de peticiones del dia
    */
    public function ipExceededToday() {
        $king = new KingMonitorUserExceeded();
        return $king->ipExceededToday();
    }

    // ---------------------------------------------------------------- IP REQUEST EXCEEDED WEEK ----------------------------------------------------------------

    /*
    * Funcion para obtener las IP que superaron el limite de peticiones de la semana
    */
    public function ipExceededWeek() {
        $king = new KingMonitorUserExceeded();
        return $king->ipExceededWeek();
    }

    // ---------------------------------------------------------------- IP REQUEST EXCEEDED MONTH ----------------------------------------------------------------

    /*
    * Funcion para obtener las IP que superaron el limite de peticiones del mes
    */
    public function ipExceededMonth() {
        $king = new KingMonitorUserExceeded();
        return $king->ipExceededMonth();
    }

    // ---------------------------------------------------------------- IP REQUEST EXCEEDED QUARTER ----------------------------------------------------------------

    /*
    * Funcion para obtener las IP que superaron el limite de peticiones del trimestre
    */
    public function ipExceededQuarter() {
        $king = new KingMonitorUserExceeded();
        return $king->ipExceededQuarter();
    }

    // ---------------------------------------------------------------- IP REQUEST EXCEEDED YEAR ----------------------------------------------------------------

    /*
    * Funcion para obtener las IP que superaron el limite de peticiones del año
    */
    public function ipExceededYear() {
        $king = new KingMonitorUserExceeded();
        return $king->ipExceededYear();
    }

    // ---------------------------------------------------------------- IP REQUEST EXCEEDED TOTAL ----------------------------------------------------------------

    /*
    * Funcion para obtener las IP que superaron el limite de peticiones de todos los tiempos
    */
    public function ipExceededTotal() {
        $king = new KingMonitorUserExceeded();
        return $king->ipExceededTotal();
    }

    /****************************************************************** USER STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- USER STATISTICS TODAY ----------------------------------------------------------------
    public function userStatisticsToday($king_user_id) {
        $king = new KingMonitorUserExceeded();
        return $king->userStatisticsToday($king_user_id);
    }

    public function userRequestStatisticsToday($king_user_id) {
        $king = new KingMonitorUserExceeded();
        return $king->userRequestStatisticsToday($king_user_id);
    }

    public function userErrorStatisticsToday($king_user_id) {
        $king = new KingMonitorUserExceeded();
        return $king->userErrorStatisticsToday($king_user_id);
    }

    // ---------------------------------------------------------------- USER STATISTICS WEEK ----------------------------------------------------------------
    public function userStatisticsWeek($king_user_id) {
        $king = new KingMonitorUserExceeded();
        return $king->userStatisticsWeek($king_user_id);
    }

    public function userRequestStatisticsWeek($king_user_id) {
        $king = new KingMonitorUserExceeded();
        return $king->userRequestStatisticsWeek($king_user_id);
    }

    public function userErrorStatisticsWeek($king_user_id) {
        $king = new KingMonitorUserExceeded();
        return $king->userErrorStatisticsWeek($king_user_id);
    }

    // ---------------------------------------------------------------- USER STATISTICS MONTH ----------------------------------------------------------------
    public function userStatisticsMonth($king_user_id) {
        $king = new KingMonitorUserExceeded();
        return $king->userStatisticsMonth($king_user_id);
    }

    public function userRequestStatisticsMonth($king_user_id) {
        $king = new KingMonitorUserExceeded();
        return $king->userRequestStatisticsMonth($king_user_id);
    }

    public function userErrorStatisticsMonth($king_user_id) {
        $king = new KingMonitorUserExceeded();
        return $king->userErrorStatisticsMonth($king_user_id);
    }

    // ---------------------------------------------------------------- USER STATISTICS QUARTER ----------------------------------------------------------------
    public function userStatisticsQuarter($king_user_id) {
        $king = new KingMonitorUserExceeded();
        return $king->userStatisticsQuarter($king_user_id);
    }

    public function userRequestStatisticsQuarter($king_user_id) {
        $king = new KingMonitorUserExceeded();
        return $king->userRequestStatisticsQuarter($king_user_id);
    }

    public function userErrorStatisticsQuarter($king_user_id) {
        $king = new KingMonitorUserExceeded();
        return $king->userErrorStatisticsQuarter($king_user_id);
    }

    // ---------------------------------------------------------------- USER STATISTICS YEAR ----------------------------------------------------------------
    public function userStatisticsYear($king_user_id) {
        $king = new KingMonitorUserExceeded();
        return $king->userStatisticsYear($king_user_id);
    }

    public function userRequestStatisticsYear($king_user_id) {
        $king = new KingMonitorUserExceeded();
        return $king->userRequestStatisticsYear($king_user_id);
    }

    public function userErrorStatisticsYear($king_user_id) {
        $king = new KingMonitorUserExceeded();
        return $king->userErrorStatisticsYear($king_user_id);
    }

    // ---------------------------------------------------------------- USER STATISTICS TOTAL ----------------------------------------------------------------
    public function userStatisticsTotal($king_user_id) {
        $king = new KingMonitorUserExceeded();
        return $king->userStatisticsTotal($king_user_id);
    }

    public function userRequestStatisticsTotal($king_user_id) {
        $king = new KingMonitorUserExceeded();
        return $king->userRequestStatisticsTotal($king_user_id);
    }

    public function userErrorStatisticsTotal($king_user_id) {
        $king = new KingMonitorUserExceeded();
        return $king->userErrorStatisticsTotal($king_user_id);
    }

    // ---------------------------------------------------------------- USER STATISTICS ----------------------------------------------------------------
    public function userStatistics($king_user_id) {
        $king = new KingMonitorUserExceeded();
        return $king->userStatistics($king_user_id);
    }

    public function userRequestStatistics($king_user_id) {
        $king = new KingMonitorUserExceeded();
        return $king->userRequestStatistics($king_user_id);
    }

    public function userErrorStatistics($king_user_id) {
        $king = new KingMonitorUserExceeded();
        return $king->userErrorStatistics($king_user_id);
    }

    /****************************************************************** STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS TODAY ----------------------------------------------------------------
    public function statisticsToday() {
        $king = new KingMonitorUserExceeded();
        return $king->statisticsToday();
    }

    public function requestStatisticsToday() {
        $king = new KingMonitorUserExceeded();
        return $king->requestStatisticsToday();
    }

    public function errorStatisticsToday() {
        $king = new KingMonitorUserExceeded();
        return $king->errorStatisticsToday();
    }

    // ---------------------------------------------------------------- STATISTICS WEEK ----------------------------------------------------------------
    public function statisticsWeek() {
        $king = new KingMonitorUserExceeded();
        return $king->statisticsWeek();
    }

    public function requestStatisticsWeek() {
        $king = new KingMonitorUserExceeded();
        return $king->requestStatisticsWeek();
    }

    public function errorStatisticsWeek() {
        $king = new KingMonitorUserExceeded();
        return $king->errorStatisticsWeek();
    }

    // ---------------------------------------------------------------- STATISTICS MONTH ----------------------------------------------------------------
    public function statisticsMonth() {
        $king = new KingMonitorUserExceeded();
        return $king->statisticsMonth();
    }

    public function requestStatisticsMonth() {
        $king = new KingMonitorUserExceeded();
        return $king->requestStatisticsMonth();
    }

    public function errorStatisticsMonth() {
        $king = new KingMonitorUserExceeded();
        return $king->errorStatisticsMonth();
    }

    // ---------------------------------------------------------------- STATISTICS QUARTER ----------------------------------------------------------------
    public function statisticsQuarter() {
        $king = new KingMonitorUserExceeded();
        return $king->statisticsQuarter();
    }

    public function requestStatisticsQuarter() {
        $king = new KingMonitorUserExceeded();
        return $king->requestStatisticsQuarter();
    }

    public function errorStatisticsQuarter() {
        $king = new KingMonitorUserExceeded();
        return $king->errorStatisticsQuarter();
    }

    // ---------------------------------------------------------------- STATISTICS YEAR ----------------------------------------------------------------
    public function statisticsYear() {
        $king = new KingMonitorUserExceeded();
        return $king->statisticsYear();
    }

    public function requestStatisticsYear() {
        $king = new KingMonitorUserExceeded();
        return $king->requestStatisticsYear();
    }

    public function errorStatisticsYear() {
        $king = new KingMonitorUserExceeded();
        return $king->errorStatisticsYear();
    }

    // ---------------------------------------------------------------- STATISTICS TOTAL ----------------------------------------------------------------
    public function statisticsTotal() {
        $king = new KingMonitorUserExceeded();
        return $king->statisticsTotal();
    }

    public function requestStatisticsTotal() {
        $king = new KingMonitorUserExceeded();
        return $king->requestStatisticsTotal();
    }

    public function errorStatisticsTotal() {
        $king = new KingMonitorUserExceeded();
        return $king->errorStatisticsTotal();
    }

    // ---------------------------------------------------------------- STATISTICS ----------------------------------------------------------------
    public function statistics() {
        $king = new KingMonitorUserExceeded();
        return $king->statistics();
    }

    public function requestStatistics() {
        $king = new KingMonitorUserExceeded();
        return $king->requestStatistics();
    }

    public function errorStatistics() {
        $king = new KingMonitorUserExceeded();
        return $king->errorStatistics();
    }
}
