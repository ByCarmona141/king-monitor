<?php
use Illuminate\Support\Facades\Route;
use ByCarmona141\KingMonitor\Http\Controllers\API\KingMonitorController;
use ByCarmona141\KingMonitor\Http\Controllers\API\KingMonitorAlertController;
use ByCarmona141\KingMonitor\Http\Controllers\API\KingMonitorErrorController;
use ByCarmona141\KingMonitor\Http\Controllers\API\KingMonitorRequestController;
use ByCarmona141\KingMonitor\Http\Controllers\API\KingMonitorAverageController;
use ByCarmona141\KingMonitor\Http\Controllers\API\KingMonitorUserExceededController;

// KingMonitorAlert
Route::middleware(['auth:api', 'monitor-auth'])->controller(KingMonitorAlertController::class)->group(function () {
    Route::get('/kingMonitorAlert/lastAlertToday', 'lastAlertToday')->name('api.v1.kingMonitorAlert.lastAlertToday');
    Route::post('/kingMonitorAlert/day', 'day')->name('api.v1.kingMonitorAlert.day');
    Route::post('/kingMonitorAlert/dayCount', 'dayCount')->name('api.v1.kingMonitorAlert.dayCount');
    Route::post('/kingMonitorAlert/month', 'month')->name('api.v1.kingMonitorAlert.month');
    Route::post('/kingMonitorAlert/monthYear', 'monthYear')->name('api.v1.kingMonitorAlert.monthYear');
});
Route::middleware(['auth:api', 'monitor-auth'])->apiResource('/kingMonitorAlert', KingMonitorAlertController::class)->names('api.v1.kingMonitorAlert');

// KingMonitorAverage
Route::middleware(['auth:api', 'monitor-auth'])->controller(KingMonitorAverageController::class)->group(function () {
    Route::get('/kingMonitorAverage/averageMonitor', 'averageMonitor')->name('api.v1.kingMonitorAverage.averageMonitor');
});
Route::middleware(['auth:api', 'monitor-auth'])->apiResource('/kingMonitorAverage', KingMonitorAverageController::class)->names('api.v1.kingMonitorAverage');

// KingMonitor
Route::middleware(['auth:api', 'monitor-auth'])->controller(KingMonitorController::class)->group(function () {
    Route::get('/kingMonitor/limit','limit')->name('api.v1.kingMonitor.limit');

    /****************************************************************** USER STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- USER STATISTICS TODAY ----------------------------------------------------------------
    Route::get('/kingMonitor/userStatisticsToday/{king_user_id}','userStatisticsToday')->name('api.v1.kingMonitor.userStatisticsToday'); // Obtener las estadisticas de un usuario (today)
    Route::get('/kingMonitor/userMethodStatisticsToday/{king_user_id}','userMethodStatisticsToday')->name('api.v1.kingMonitor.userMethodStatisticsToday'); // Obtener las estadisticas de los metodos de un usuario (today)

    // ---------------------------------------------------------------- USER STATISTICS WEEK ----------------------------------------------------------------
    Route::get('/kingMonitor/userStatisticsWeek/{king_user_id}','userStatisticsWeek')->name('api.v1.kingMonitor.userStatisticsWeek'); // Obtener las estadisticas de un usuario (week)
    Route::get('/kingMonitor/userMethodStatisticsWeek/{king_user_id}','userMethodStatisticsWeek')->name('api.v1.kingMonitor.userMethodStatisticsWeek'); // Obtener las estadisticas de los metodos de un usuario (week)

    // ---------------------------------------------------------------- USER STATISTICS MONTH ----------------------------------------------------------------
    Route::get('/kingMonitor/userStatisticsMonth/{king_user_id}','userStatisticsMonth')->name('api.v1.kingMonitor.userStatisticsMonth'); // Obtener las estadisticas de un usuario (month)
    Route::get('/kingMonitor/userMethodStatisticsMonth/{king_user_id}','userMethodStatisticsMonth')->name('api.v1.kingMonitor.userMethodStatisticsMonth'); // Obtener las estadisticas de los metodos de un usuario (month)

    // ---------------------------------------------------------------- USER STATISTICS QUARTER ----------------------------------------------------------------
    Route::get('/kingMonitor/userStatisticsQuarter/{king_user_id}','userStatisticsQuarter')->name('api.v1.kingMonitor.userStatisticsQuarter'); // Obtener las estadisticas de un usuario (quarter)
    Route::get('/kingMonitor/userMethodStatisticsQuarter/{king_user_id}','userMethodStatisticsQuarter')->name('api.v1.kingMonitor.userMethodStatisticsQuarter'); // Obtener las estadisticas de los metodos de un usuario (quarter)

    // ---------------------------------------------------------------- USER STATISTICS YEAR ----------------------------------------------------------------
    Route::get('/kingMonitor/userStatisticsYear/{king_user_id}','userStatisticsYear')->name('api.v1.kingMonitor.userStatisticsYear'); // Obtener las estadisticas de un usuario (year)
    Route::get('/kingMonitor/userMethodStatisticsYear/{king_user_id}','userMethodStatisticsYear')->name('api.v1.kingMonitor.userMethodStatisticsYear'); // Obtener las estadisticas de los metodos de un usuario (year)

    // ---------------------------------------------------------------- USER STATISTICS TOTAL ----------------------------------------------------------------
    Route::get('/kingMonitor/userStatisticsTotal/{king_user_id}','userStatisticsTotal')->name('api.v1.kingMonitor.userStatisticsTotal'); // Obtener las estadisticas de un usuario (total)
    Route::get('/kingMonitor/userMethodStatisticsTotal/{king_user_id}','userMethodStatisticsTotal')->name('api.v1.kingMonitor.userMethodStatisticsTotal'); // Obtener las estadisticas de los metodos de un usuario (total)

    /****************************************************************** STATISTICS REQUEST USERS ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS REQUEST USERS TODAY ----------------------------------------------------------------
    Route::get('/kingMonitor/userRequestStatisticsToday/{king_user_id}','userRequestStatisticsToday')->name('api.v1.kingMonitor.userRequestStatisticsToday'); // Obtener las estadisticas de un usuario (today)
    Route::get('/kingMonitor/userRequestMethodStatisticsToday/{king_user_id}','userRequestMethodStatisticsToday')->name('api.v1.kingMonitor.userRequestMethodStatisticsToday'); // Obtener las estadisticas de los metodos de un usuario (today)

    // ---------------------------------------------------------------- STATISTICS REQUEST USERS WEEK ----------------------------------------------------------------
    Route::get('/kingMonitor/userRequestStatisticsWeek/{king_user_id}','userRequestStatisticsWeek')->name('api.v1.kingMonitor.userRequestStatisticsWeek'); // Obtener las estadisticas de un usuario (week)
    Route::get('/kingMonitor/userRequestMethodStatisticsWeek/{king_user_id}','userRequestMethodStatisticsWeek')->name('api.v1.kingMonitor.userRequestMethodStatisticsWeek'); // Obtener las estadisticas de los metodos de un usuario (week)

    // ---------------------------------------------------------------- STATISTICS REQUEST USERS MONTH ----------------------------------------------------------------
    Route::get('/kingMonitor/userRequestStatisticsMonth/{king_user_id}','userRequestStatisticsMonth')->name('api.v1.kingMonitor.userRequestStatisticsMonth'); // Obtener las estadisticas de un usuario (month)
    Route::get('/kingMonitor/userRequestMethodStatisticsMonth/{king_user_id}','userRequestMethodStatisticsMonth')->name('api.v1.kingMonitor.userRequestMethodStatisticsMonth'); // Obtener las estadisticas de los metodos de un usuario (month)

    // ---------------------------------------------------------------- STATISTICS REQUEST USERS QUARTER ----------------------------------------------------------------
    Route::get('/kingMonitor/userRequestStatisticsQuarter/{king_user_id}','userRequestStatisticsQuarter')->name('api.v1.kingMonitor.userRequestStatisticsQuarter'); // Obtener las estadisticas de un usuario (quarter)
    Route::get('/kingMonitor/userRequestMethodStatisticsQuarter/{king_user_id}','userRequestMethodStatisticsQuarter')->name('api.v1.kingMonitor.userRequestMethodStatisticsQuarter'); // Obtener las estadisticas de los metodos de un usuario (quarter)

    // ---------------------------------------------------------------- STATISTICS REQUEST USERS YEAR ----------------------------------------------------------------
    Route::get('/kingMonitor/userRequestStatisticsYear/{king_user_id}','userRequestStatisticsYear')->name('api.v1.kingMonitor.userRequestStatisticsYear'); // Obtener las estadisticas de un usuario (year)
    Route::get('/kingMonitor/userRequestMethodStatisticsYear/{king_user_id}','userRequestMethodStatisticsYear')->name('api.v1.kingMonitor.userRequestMethodStatisticsYear'); // Obtener las estadisticas de los metodos de un usuario (year)

    // ---------------------------------------------------------------- STATISTICS REQUEST USERS TOTAL ----------------------------------------------------------------
    Route::get('/kingMonitor/userRequestStatisticsTotal/{king_user_id}','userRequestStatisticsTotal')->name('api.v1.kingMonitor.userRequestStatisticsTotal'); // Obtener las estadisticas de un usuario (total)
    Route::get('/kingMonitor/userRequestMethodStatisticsTotal/{king_user_id}','userRequestMethodStatisticsTotal')->name('api.v1.kingMonitor.userRequestMethodStatisticsTotal'); // Obtener las estadisticas de los metodos de un usuario (total)

    /****************************************************************** REQUEST STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- REQUEST STATISTICS TODAY ----------------------------------------------------------------
    Route::get('/kingMonitor/requestStatisticsToday','requestStatisticsToday')->name('api.v1.kingMonitor.requestStatisticsToday'); // Obtener las estadisticas (today)
    Route::get('/kingMonitor/requestMethodStatisticsToday','requestMethodStatisticsToday')->name('api.v1.kingMonitor.requestMethodStatisticsToday'); // Obtener las estadisticas de los metodos (today)
    Route::get('/kingMonitor/requestStatisticsFrequentUserToday','requestStatisticsFrequentUserToday')->name('api.v1.kingMonitor.requestStatisticsFrequentUserToday'); // Obtener el usuario mas comun (today)

    // ---------------------------------------------------------------- STATISTICS REQUEST WEEK ----------------------------------------------------------------
    Route::get('/kingMonitor/requestStatisticsWeek','requestStatisticsWeek')->name('api.v1.kingMonitor.requestStatisticsWeek'); // Obtener el metodo mas comun (week)
    Route::get('/kingMonitor/requestMethodStatisticsWeek','requestMethodStatisticsWeek')->name('api.v1.kingMonitor.requestMethodStatisticsWeek'); // Obtener las estadisticas de los metodos (week)
    Route::get('/kingMonitor/requestStatisticsFrequentUserWeek','requestStatisticsFrequentUserWeek')->name('api.v1.kingMonitor.requestStatisticsFrequentUserWeek'); // Obtener el usuario mas comun (week)

    // ---------------------------------------------------------------- STATISTICS REQUEST MONTH ----------------------------------------------------------------
    Route::get('/kingMonitor/requestStatisticsMonth','requestStatisticsMonth')->name('api.v1.kingMonitor.requestStatisticsMonth'); // Obtener el metodo mas comun (month)
    Route::get('/kingMonitor/requestMethodStatisticsMonth','requestMethodStatisticsMonth')->name('api.v1.kingMonitor.requestMethodStatisticsMonth'); // Obtener las estadisticas de los metodos (month)
    Route::get('/kingMonitor/requestStatisticsFrequentUserMonth','requestStatisticsFrequentUserMonth')->name('api.v1.kingMonitor.requestStatisticsFrequentUserMonth'); // Obtener el usuario mas comun (month)

    // ---------------------------------------------------------------- STATISTICS REQUEST QUARTER ----------------------------------------------------------------
    Route::get('/kingMonitor/requestStatisticsQuarter','requestStatisticsQuarter')->name('api.v1.kingMonitor.requestStatisticsQuarter'); // Obtener el metodo mas comun (quarter)
    Route::get('/kingMonitor/requestMethodStatisticsQuarter','requestMethodStatisticsQuarter')->name('api.v1.kingMonitor.requestMethodStatisticsQuarter'); // Obtener las estadisticas de los metodos (quarter)
    Route::get('/kingMonitor/requestStatisticsFrequentUserQuarter','requestStatisticsFrequentUserQuarter')->name('api.v1.kingMonitor.requestStatisticsFrequentUserQuarter'); // Obtener el usuario mas comun (quarter)

    // ---------------------------------------------------------------- STATISTICS REQUEST YEAR ----------------------------------------------------------------
    Route::get('/kingMonitor/requestStatisticsYear','requestStatisticsYear')->name('api.v1.kingMonitor.requestStatisticsYear'); // Obtener el metodo mas comun (year)
    Route::get('/kingMonitor/requestMethodStatisticsYear','requestMethodStatisticsYear')->name('api.v1.kingMonitor.requestMethodStatisticsYear'); // Obtener las estadisticas de los metodos (year)
    Route::get('/kingMonitor/requestStatisticsFrequentUserYear','requestStatisticsFrequentUserYear')->name('api.v1.kingMonitor.requestStatisticsFrequentUserYear'); // Obtener el usuario mas comun (year)

    // ---------------------------------------------------------------- STATISTICS REQUEST TOTAL ----------------------------------------------------------------
    Route::get('/kingMonitor/requestStatisticsTotal','requestStatisticsTotal')->name('api.v1.kingMonitor.requestStatisticsTotal'); // Obtener las estadisticas (total)
    Route::get('/kingMonitor/requestMethodStatisticsTotal','requestMethodStatisticsTotal')->name('api.v1.kingMonitor.requestMethodStatisticsTotal'); // Obtener las estadisticas de los metodos (total)
    Route::get('/kingMonitor/requestStatisticsFrequentUserTotal','requestStatisticsFrequentUserTotal')->name('api.v1.kingMonitor.requestStatisticsFrequentUserTotal'); // Obtener el usuario mas comun (total)

    /****************************************************************** USER ERROR STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- USER ERROR STATISTICS TODAY ----------------------------------------------------------------
    Route::get('/kingMonitor/userErrorStatisticsToday/{king_user_id}','userErrorStatisticsToday')->name('api.v1.kingMonitor.userErrorStatisticsToday'); // Obtener las estadisticas de errores de un usuario (today)
    Route::get('/kingMonitor/userErrorMethodStatisticsToday/{king_user_id}','userErrorMethodStatisticsToday')->name('api.v1.kingMonitor.userErrorMethodStatisticsToday'); // Obtener las estadisticas de errores de los metodos de un usuario (today)

    // ---------------------------------------------------------------- STATISTICS ERRORS USERS WEEK ----------------------------------------------------------------
    Route::get('/kingMonitor/userErrorStatisticsWeek/{king_user_id}','userErrorStatisticsWeek')->name('api.v1.kingMonitor.userErrorStatisticsWeek'); // Obtener las estadisticas de errores de un usuario (week)
    Route::get('/kingMonitor/userErrorMethodStatisticsWeek/{king_user_id}','userErrorMethodStatisticsWeek')->name('api.v1.kingMonitor.userErrorMethodStatisticsWeek'); // Obtener las estadisticas de errores de los metodos de un usuario (week)

    // ---------------------------------------------------------------- STATISTICS ERRORS USERS MONTH ----------------------------------------------------------------
    Route::get('/kingMonitor/userErrorStatisticsMonth/{king_user_id}','userErrorStatisticsMonth')->name('api.v1.kingMonitor.userErrorStatisticsMonth'); // Obtener las estadisticas de errores de un usuario (month)
    Route::get('/kingMonitor/userErrorMethodStatisticsMonth/{king_user_id}','userErrorMethodStatisticsMonth')->name('api.v1.kingMonitor.userErrorMethodStatisticsMonth'); // Obtener las estadisticas de errores de los metodos de un usuario (month)

    // ---------------------------------------------------------------- STATISTICS ERRORS USERS QUARTER ----------------------------------------------------------------
    Route::get('/kingMonitor/userErrorStatisticsQuarter/{king_user_id}','userErrorStatisticsQuarter')->name('api.v1.kingMonitor.userErrorStatisticsQuarter'); // Obtener las estadisticas de errores de un usuario (quarter)
    Route::get('/kingMonitor/userErrorMethodStatisticsQuarter/{king_user_id}','userErrorMethodStatisticsQuarter')->name('api.v1.kingMonitor.userErrorMethodStatisticsQuarter'); // Obtener las estadisticas de errores de los metodos de un usuario (quarter)

    // ---------------------------------------------------------------- STATISTICS ERRORS USERS YEAR ----------------------------------------------------------------
    Route::get('/kingMonitor/userErrorStatisticsYear/{king_user_id}','userErrorStatisticsYear')->name('api.v1.kingMonitor.userErrorStatisticsYear'); // Obtener las estadisticas de errores de un usuario (year)
    Route::get('/kingMonitor/userErrorMethodStatisticsYear/{king_user_id}','userErrorMethodStatisticsYear')->name('api.v1.kingMonitor.userErrorMethodStatisticsYear'); // Obtener las estadisticas de errores de los metodos de un usuario (year)

    // ---------------------------------------------------------------- STATISTICS ERRORS USERS TOTAL ----------------------------------------------------------------
    Route::get('/kingMonitor/userErrorStatisticsTotal/{king_user_id}','userErrorStatisticsTotal')->name('api.v1.kingMonitor.userErrorStatisticsTotal'); // Obtener las estadisticas de errores de un usuario (total)
    Route::get('/kingMonitor/userErrorMethodStatisticsTotal/{king_user_id}','userErrorMethodStatisticsTotal')->name('api.v1.kingMonitor.userErrorMethodStatisticsTotal'); // Obtener las estadisticas de errores de los metodos de un usuario (total)

    /****************************************************************** STATISTICS ERRORS ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS ERRORS TODAY ----------------------------------------------------------------
    Route::get('/kingMonitor/errorStatisticsToday','errorStatisticsToday')->name('api.v1.kingMonitor.errorStatisticsToday'); // Obtener las estadisticas (today)
    Route::get('/kingMonitor/errorMethodStatisticsToday','errorMethodStatisticsToday')->name('api.v1.kingMonitor.errorMethodStatisticsToday'); // Obtener las estadisticas de los metodos (today)
    Route::get('/kingMonitor/errorStatisticsFrequentUserToday','errorStatisticsFrequentUserToday')->name('api.v1.kingMonitor.errorStatisticsFrequentUserToday'); // Obtener el usuario mas comun (today)

    // ---------------------------------------------------------------- STATISTICS ERRORS WEEK ----------------------------------------------------------------
    Route::get('/kingMonitor/errorStatisticsWeek','errorStatisticsWeek')->name('api.v1.kingMonitor.errorStatisticsWeek'); // Obtener el metodo mas comun (week)
    Route::get('/kingMonitor/errorMethodStatisticsWeek','errorMethodStatisticsWeek')->name('api.v1.kingMonitor.errorMethodStatisticsWeek'); // Obtener las estadisticas de los metodos (week)
    Route::get('/kingMonitor/errorStatisticsFrequentUserWeek','errorStatisticsFrequentUserWeek')->name('api.v1.kingMonitor.errorStatisticsFrequentUserWeek'); // Obtener el usuario mas comun (week)

    // ---------------------------------------------------------------- STATISTICS ERRORS MONTH ----------------------------------------------------------------
    Route::get('/kingMonitor/errorStatisticsMonth','errorStatisticsMonth')->name('api.v1.kingMonitor.errorStatisticsMonth'); // Obtener el metodo mas comun (month)
    Route::get('/kingMonitor/errorMethodStatisticsMonth','errorMethodStatisticsMonth')->name('api.v1.kingMonitor.errorMethodStatisticsMonth'); // Obtener las estadisticas de los metodos (month)
    Route::get('/kingMonitor/errorStatisticsFrequentUserMonth','errorStatisticsFrequentUserMonth')->name('api.v1.kingMonitor.errorStatisticsFrequentUserMonth'); // Obtener el usuario mas comun (month)

    // ---------------------------------------------------------------- STATISTICS ERRORS QUARTER ----------------------------------------------------------------
    Route::get('/kingMonitor/errorStatisticsQuarter','errorStatisticsQuarter')->name('api.v1.kingMonitor.errorStatisticsQuarter'); // Obtener el metodo mas comun (quarter)
    Route::get('/kingMonitor/errorMethodStatisticsQuarter','errorMethodStatisticsQuarter')->name('api.v1.kingMonitor.errorMethodStatisticsQuarter'); // Obtener las estadisticas de los metodos (quarter)
    Route::get('/kingMonitor/errorStatisticsFrequentUserQuarter','errorStatisticsFrequentUserQuarter')->name('api.v1.kingMonitor.errorStatisticsFrequentUserQuarter'); // Obtener el usuario mas comun (quarter)

    // ---------------------------------------------------------------- STATISTICS ERRORS YEAR ----------------------------------------------------------------
    Route::get('/kingMonitor/errorStatisticsYear','errorStatisticsYear')->name('api.v1.kingMonitor.errorStatisticsYear'); // Obtener el metodo mas comun (year)
    Route::get('/kingMonitor/errorMethodStatisticsYear','errorMethodStatisticsYear')->name('api.v1.kingMonitor.errorMethodStatisticsYear'); // Obtener las estadisticas de los metodos (year)
    Route::get('/kingMonitor/errorStatisticsFrequentUserYear','errorStatisticsFrequentUserYear')->name('api.v1.kingMonitor.errorStatisticsFrequentUserYear'); // Obtener el usuario mas comun (year)

    // ---------------------------------------------------------------- STATISTICS ERRORS TOTAL ----------------------------------------------------------------
    Route::get('/kingMonitor/errorStatisticsTotal','errorStatisticsTotal')->name('api.v1.kingMonitor.errorStatisticsTotal'); // Obtener las estadisticas (total)
    Route::get('/kingMonitor/errorMethodStatisticsTotal','errorMethodStatisticsTotal')->name('api.v1.kingMonitor.errorMethodStatisticsTotal'); // Obtener las estadisticas de los metodos (total)
    Route::get('/kingMonitor/errorStatisticsFrequentUserTotal','errorStatisticsFrequentUserTotal')->name('api.v1.kingMonitor.errorStatisticsFrequentUserTotal'); // Obtener el usuario mas comun (total)

    /****************************************************************** STATISTICS REQUEST ENDPOINT ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS REQUEST ENDPOINT TOTAL ----------------------------------------------------------------
    Route::get('/kingMonitor/requestStatisticsEndpointTotal','requestStatisticsEndpointTotal')->name('api.v1.kingMonitor.requestStatisticsEndpointTotal'); // Obtener las estadisticas de los endpoints de todos los tiempos

    /****************************************************************** STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS TODAY ----------------------------------------------------------------
    Route::get('/kingMonitor/statisticsToday','statisticsToday')->name('api.v1.kingMonitor.statisticsToday'); // Obtener las estadisticas (today)
    Route::get('/kingMonitor/methodStatisticsToday','methodStatisticsToday')->name('api.v1.kingMonitor.methodStatisticsToday'); // Obtener las estadisticas de los metodos (today)
    Route::get('/kingMonitor/statisticsFrequentUserToday','statisticsFrequentUserToday')->name('api.v1.kingMonitor.statisticsFrequentUserToday'); // Obtener el usuario mas comun (today)

    // ---------------------------------------------------------------- STATISTICS WEEK ----------------------------------------------------------------
    Route::get('/kingMonitor/statisticsWeek','statisticsWeek')->name('api.v1.kingMonitor.statisticsWeek'); // Obtener el metodo mas comun (week)
    Route::get('/kingMonitor/methodStatisticsWeek','methodStatisticsWeek')->name('api.v1.kingMonitor.methodStatisticsWeek'); // Obtener las estadisticas de los metodos (week)
    Route::get('/kingMonitor/statisticsFrequentUserWeek','statisticsFrequentUserWeek')->name('api.v1.kingMonitor.statisticsFrequentUserWeek'); // Obtener el usuario mas comun (week)

    // ---------------------------------------------------------------- STATISTICS MONTH ----------------------------------------------------------------
    Route::get('/kingMonitor/statisticsMonth','statisticsMonth')->name('api.v1.kingMonitor.statisticsMonth'); // Obtener el metodo mas comun (month)
    Route::get('/kingMonitor/methodStatisticsMonth','methodStatisticsMonth')->name('api.v1.kingMonitor.methodStatisticsMonth'); // Obtener las estadisticas de los metodos (month)
    Route::get('/kingMonitor/statisticsFrequentUserMonth','statisticsFrequentUserMonth')->name('api.v1.kingMonitor.statisticsFrequentUserMonth'); // Obtener el usuario mas comun (month)

    // ---------------------------------------------------------------- STATISTICS QUARTER ----------------------------------------------------------------
    Route::get('/kingMonitor/statisticsQuarter','statisticsQuarter')->name('api.v1.kingMonitor.statisticsQuarter'); // Obtener el metodo mas comun (quarter)
    Route::get('/kingMonitor/methodStatisticsQuarter','methodStatisticsQuarter')->name('api.v1.kingMonitor.methodStatisticsQuarter'); // Obtener las estadisticas de los metodos (quarter)
    Route::get('/kingMonitor/statisticsFrequentUserQuarter','statisticsFrequentUserQuarter')->name('api.v1.kingMonitor.statisticsFrequentUserQuarter'); // Obtener el usuario mas comun (quarter)

    // ---------------------------------------------------------------- STATISTICS YEAR ----------------------------------------------------------------
    Route::get('/kingMonitor/statisticsYear','statisticsYear')->name('api.v1.kingMonitor.statisticsYear'); // Obtener el metodo mas comun (year)
    Route::get('/kingMonitor/methodStatisticsYear','methodStatisticsYear')->name('api.v1.kingMonitor.methodStatisticsYear'); // Obtener las estadisticas de los metodos (year)
    Route::get('/kingMonitor/statisticsFrequentUserYear','statisticsFrequentUserYear')->name('api.v1.kingMonitor.statisticsFrequentUserYear'); // Obtener el usuario mas comun (year)

    // ---------------------------------------------------------------- STATISTICS TOTAL ----------------------------------------------------------------
    Route::get('/kingMonitor/statisticsTotal','statisticsTotal')->name('api.v1.kingMonitor.statisticsTotal'); // Obtener las estadisticas (total)
    Route::get('/kingMonitor/methodStatisticsTotal','methodStatisticsTotal')->name('api.v1.kingMonitor.methodStatisticsTotal'); // Obtener las estadisticas de los metodos (total)
    Route::get('/kingMonitor/statisticsFrequentUserTotal','statisticsFrequentUserTotal')->name('api.v1.kingMonitor.statisticsFrequentUserTotal'); // Obtener el usuario mas comun (total)

    // ---------------------------------------------------------------- STATISTICS ----------------------------------------------------------------
    Route::get('/kingMonitor/statistics','statistics')->name('api.v1.kingMonitor.statistics');
    Route::get('/kingMonitor/userStatistics/{king_user_id}','userStatistics')->name('api.v1.kingMonitor.userStatistics');
    Route::get('/kingMonitor/requestStatistics','requestStatistics')->name('api.v1.kingMonitor.requestStatistics');
    Route::get('/kingMonitor/userRequestStatistics/{king_user_id}','userRequestStatistics')->name('api.v1.kingMonitor.userRequestStatistics');
    Route::get('/kingMonitor/errorStatistics','errorStatistics')->name('api.v1.kingMonitor.errorStatistics');
    Route::get('/kingMonitor/userErrorStatistics/{king_user_id}','userErrorStatistics')->name('api.v1.kingMonitor.userErrorStatistics');

    /****************************************************************** USER STATISTICS EXCEEDED ******************************************************************/
    // ---------------------------------------------------------------- USER STATISTICS EXCEEDED REQUEST ----------------------------------------------------------------
    Route::get('/kingMonitor/userRequestStatisticsExceededToday/{king_user_id}','userRequestStatisticsExceededToday')->name('api.v1.kingMonitor.userRequestStatisticsExceededToday');
    Route::get('/kingMonitor/userRequestStatisticsExceededWeek/{king_user_id}','userRequestStatisticsExceededWeek')->name('api.v1.kingMonitor.userRequestStatisticsExceededWeek');
    Route::get('/kingMonitor/userRequestStatisticsExceededMonth/{king_user_id}','userRequestStatisticsExceededMonth')->name('api.v1.kingMonitor.userRequestStatisticsExceededMonth');
    Route::get('/kingMonitor/userRequestStatisticsExceededQuarter/{king_user_id}','userRequestStatisticsExceededQuarter')->name('api.v1.kingMonitor.userRequestStatisticsExceededQuarter');
    Route::get('/kingMonitor/userRequestStatisticsExceededYear/{king_user_id}','userRequestStatisticsExceededYear')->name('api.v1.kingMonitor.userRequestStatisticsExceededYear');
    Route::get('/kingMonitor/userRequestStatisticsExceededTotal/{king_user_id}','userRequestStatisticsExceededTotal')->name('api.v1.kingMonitor.userRequestStatisticsExceededTotal');

    // ---------------------------------------------------------------- USER STATISTICS EXCEEDED ERROR ----------------------------------------------------------------
    Route::get('/kingMonitor/userErrorStatisticsExceededToday/{king_user_id}','userErrorStatisticsExceededToday')->name('api.v1.kingMonitor.userErrorStatisticsExceededToday');
    Route::get('/kingMonitor/userErrorStatisticsExceededWeek/{king_user_id}','userErrorStatisticsExceededWeek')->name('api.v1.kingMonitor.userErrorStatisticsExceededWeek');
    Route::get('/kingMonitor/userErrorStatisticsExceededMonth/{king_user_id}','userErrorStatisticsExceededMonth')->name('api.v1.kingMonitor.userErrorStatisticsExceededMonth');
    Route::get('/kingMonitor/userErrorStatisticsExceededQuarter/{king_user_id}','userErrorStatisticsExceededQuarter')->name('api.v1.kingMonitor.userErrorStatisticsExceededQuarter');
    Route::get('/kingMonitor/userErrorStatisticsExceededYear/{king_user_id}','userErrorStatisticsExceededYear')->name('api.v1.kingMonitor.userErrorStatisticsExceededYear');
    Route::get('/kingMonitor/userErrorStatisticsExceededTotal/{king_user_id}','userErrorStatisticsExceededTotal')->name('api.v1.kingMonitor.userErrorStatisticsExceededTotal');

    // ---------------------------------------------------------------- USER STATISTICS EXCEEDED ----------------------------------------------------------------
    Route::get('/kingMonitor/userStatisticsExceededToday/{king_user_id}','userStatisticsExceededToday')->name('api.v1.kingMonitor.userStatisticsExceededToday');
    Route::get('/kingMonitor/userStatisticsExceededWeek/{king_user_id}','userStatisticsExceededWeek')->name('api.v1.kingMonitor.userStatisticsExceededWeek');
    Route::get('/kingMonitor/userStatisticsExceededMonth/{king_user_id}','userStatisticsExceededMonth')->name('api.v1.kingMonitor.userStatisticsExceededMonth');
    Route::get('/kingMonitor/userStatisticsExceededQuarter/{king_user_id}','userStatisticsExceededQuarter')->name('api.v1.kingMonitor.userStatisticsExceededQuarter');
    Route::get('/kingMonitor/userStatisticsExceededYear/{king_user_id}','userStatisticsExceededYear')->name('api.v1.kingMonitor.userStatisticsExceededYear');
    Route::get('/kingMonitor/userStatisticsExceededTotal/{king_user_id}','userStatisticsExceededTotal')->name('api.v1.kingMonitor.userStatisticsExceededTotal');

    // ---------------------------------------------------------------- USER STATISTICS EXCEEDED ----------------------------------------------------------------
    Route::get('/kingMonitor/userRequestStatisticsExceeded/{king_user_id}','userRequestStatisticsExceeded')->name('api.v1.kingMonitor.userRequestStatisticsExceeded');
    Route::get('/kingMonitor/userErrorStatisticsExceeded/{king_user_id}','userErrorStatisticsExceeded')->name('api.v1.kingMonitor.userErrorStatisticsExceeded');
    Route::get('/kingMonitor/userStatisticsExceeded/{king_user_id}','userStatisticsExceeded')->name('api.v1.kingMonitor.userStatisticsExceeded');

    /****************************************************************** STATISTICS EXCEEDED ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS EXCEEDED REQUEST ----------------------------------------------------------------
    Route::get('/kingMonitor/requestStatisticsExceededToday','requestStatisticsExceededToday')->name('api.v1.kingMonitor.requestStatisticsExceededToday');
    Route::get('/kingMonitor/requestStatisticsExceededWeek','requestStatisticsExceededWeek')->name('api.v1.kingMonitor.requestStatisticsExceededWeek');
    Route::get('/kingMonitor/requestStatisticsExceededMonth','requestStatisticsExceededMonth')->name('api.v1.kingMonitor.requestStatisticsExceededMonth');
    Route::get('/kingMonitor/requestStatisticsExceededQuarter','requestStatisticsExceededQuarter')->name('api.v1.kingMonitor.requestStatisticsExceededQuarter');
    Route::get('/kingMonitor/requestStatisticsExceededYear','requestStatisticsExceededYear')->name('api.v1.kingMonitor.requestStatisticsExceededYear');
    Route::get('/kingMonitor/requestStatisticsExceededTotal','requestStatisticsExceededTotal')->name('api.v1.kingMonitor.requestStatisticsExceededTotal');

    // ---------------------------------------------------------------- STATISTICS EXCEEDED ERROR ----------------------------------------------------------------
    Route::get('/kingMonitor/errorStatisticsExceededToday','errorStatisticsExceededToday')->name('api.v1.kingMonitor.errorStatisticsExceededToday');
    Route::get('/kingMonitor/errorStatisticsExceededWeek','errorStatisticsExceededWeek')->name('api.v1.kingMonitor.errorStatisticsExceededWeek');
    Route::get('/kingMonitor/errorStatisticsExceededMonth','errorStatisticsExceededMonth')->name('api.v1.kingMonitor.errorStatisticsExceededMonth');
    Route::get('/kingMonitor/errorStatisticsExceededQuarter','errorStatisticsExceededQuarter')->name('api.v1.kingMonitor.errorStatisticsExceededQuarter');
    Route::get('/kingMonitor/errorStatisticsExceededYear','errorStatisticsExceededYear')->name('api.v1.kingMonitor.errorStatisticsExceededYear');
    Route::get('/kingMonitor/errorStatisticsExceededTotal','errorStatisticsExceededTotal')->name('api.v1.kingMonitor.errorStatisticsExceededTotal');

    // ---------------------------------------------------------------- STATISTICS EXCEEDED ----------------------------------------------------------------
    Route::get('/kingMonitor/statisticsExceededToday','statisticsExceededToday')->name('api.v1.kingMonitor.statisticsExceededToday');
    Route::get('/kingMonitor/statisticsExceededWeek','statisticsExceededWeek')->name('api.v1.kingMonitor.statisticsExceededWeek');
    Route::get('/kingMonitor/statisticsExceededMonth','statisticsExceededMonth')->name('api.v1.kingMonitor.statisticsExceededMonth');
    Route::get('/kingMonitor/statisticsExceededQuarter','statisticsExceededQuarter')->name('api.v1.kingMonitor.statisticsExceededQuarter');
    Route::get('/kingMonitor/statisticsExceededYear','statisticsExceededYear')->name('api.v1.kingMonitor.statisticsExceededYear');
    Route::get('/kingMonitor/statisticsExceededTotal','statisticsExceededTotal')->name('api.v1.kingMonitor.statisticsExceededTotal');

    // ---------------------------------------------------------------- STATISTICS EXCEEDED ----------------------------------------------------------------
    Route::get('/kingMonitor/requestStatisticsExceeded','requestStatisticsExceeded')->name('api.v1.kingMonitor.requestStatisticsExceeded');
    Route::get('/kingMonitor/errorStatisticsExceeded','errorStatisticsExceeded')->name('api.v1.kingMonitor.errorStatisticsExceeded');
    Route::get('/kingMonitor/statisticsExceeded','statisticsExceeded')->name('api.v1.kingMonitor.statisticsExceeded');

    /****************************************************************** USER HISTORICAL ******************************************************************/
    // ---------------------------------------------------------------- USER HISTORICAL REQUEST ----------------------------------------------------------------
    Route::get('/kingMonitor/userRequestHistoricalToday/{king_user_id}','userRequestHistoricalToday')->name('api.v1.kingMonitor.userRequestHistoricalToday'); // Obtener el historico de peticiones del usuario (today)
    Route::get('/kingMonitor/userRequestHistoricalWeek/{king_user_id}','userRequestHistoricalWeek')->name('api.v1.kingMonitor.userRequestHistoricalWeek'); // Obtener el historico de peticiones del usuario (week)
    Route::get('/kingMonitor/userRequestHistoricalMonth/{king_user_id}','userRequestHistoricalMonth')->name('api.v1.kingMonitor.userRequestHistoricalMonth'); // Obtener el historico de peticiones del usuario (month)
    Route::get('/kingMonitor/userRequestHistoricalQuarter/{king_user_id}','userRequestHistoricalQuarter')->name('api.v1.kingMonitor.userRequestHistoricalQuarter'); // Obtener el historico de peticiones del usuario (quarter)
    Route::get('/kingMonitor/userRequestHistoricalYear/{king_user_id}','userRequestHistoricalYear')->name('api.v1.kingMonitor.userRequestHistoricalYear'); // Obtener el historico de peticiones del usuario (year)
    Route::get('/kingMonitor/userRequestHistoricalTotal/{king_user_id}','userRequestHistoricalTotal')->name('api.v1.kingMonitor.userRequestHistoricalTotal'); // Obtener el historico de peticiones del usuario (total)

    // ---------------------------------------------------------------- USER HISTORICAL ERROR ----------------------------------------------------------------
    Route::get('/kingMonitor/userErrorHistoricalToday/{king_user_id}','userErrorHistoricalToday')->name('api.v1.kingMonitor.userErrorHistoricalToday'); // Obtener el historico de errores del usuario (today)
    Route::get('/kingMonitor/userErrorHistoricalWeek/{king_user_id}','userErrorHistoricalWeek')->name('api.v1.kingMonitor.userErrorHistoricalWeek'); // Obtener el historico de errores del usuario (week)
    Route::get('/kingMonitor/userErrorHistoricalMonth/{king_user_id}','userErrorHistoricalMonth')->name('api.v1.kingMonitor.userErrorHistoricalMonth'); // Obtener el historico de errores del usuario (month)
    Route::get('/kingMonitor/userErrorHistoricalQuarter/{king_user_id}','userErrorHistoricalQuarter')->name('api.v1.kingMonitor.userErrorHistoricalQuarter'); // Obtener el historico de errores del usuario (quarter)
    Route::get('/kingMonitor/userErrorHistoricalYear/{king_user_id}','userErrorHistoricalYear')->name('api.v1.kingMonitor.userErrorHistoricalYear'); // Obtener el historico de errores del usuario (year)
    Route::get('/kingMonitor/userErrorHistoricalTotal/{king_user_id}','userErrorHistoricalTotal')->name('api.v1.kingMonitor.userErrorHistoricalTotal'); // Obtener el historico de errores del usuario (total)

    // ---------------------------------------------------------------- USER HISTORICAL ----------------------------------------------------------------
    Route::get('/kingMonitor/userHistoricalToday/{king_user_id}','userHistoricalToday')->name('api.v1.kingMonitor.userHistoricalToday'); // Obtener el historico del usuario (today)
    Route::get('/kingMonitor/userHistoricalWeek/{king_user_id}','userHistoricalWeek')->name('api.v1.kingMonitor.userHistoricalWeek'); // Obtener el historico del usuario (week)
    Route::get('/kingMonitor/userHistoricalMonth/{king_user_id}','userHistoricalMonth')->name('api.v1.kingMonitor.userHistoricalMonth'); // Obtener el historico del usuario (month)
    Route::get('/kingMonitor/userHistoricalQuarter/{king_user_id}','userHistoricalQuarter')->name('api.v1.kingMonitor.userHistoricalQuarter'); // Obtener el historico del usuario (quarter)
    Route::get('/kingMonitor/userHistoricalYear/{king_user_id}','userHistoricalYear')->name('api.v1.kingMonitor.userHistoricalYear'); // Obtener el historico del usuario (year)
    Route::get('/kingMonitor/userHistoricalTotal/{king_user_id}','userHistoricalTotal')->name('api.v1.kingMonitor.userHistoricalTotal'); // Obtener el historico del usuario (total)

    // ---------------------------------------------------------------- REQUEST HISTORICAL ----------------------------------------------------------------
    Route::get('/kingMonitor/requestHistoricalToday','requestHistoricalToday')->name('api.v1.kingMonitor.requestHistoricalToday'); // Obtener el historico de peticiones (today)
    Route::get('/kingMonitor/requestHistoricalWeek','requestHistoricalWeek')->name('api.v1.kingMonitor.requestHistoricalWeek'); // Obtener el historico de peticiones (week)
    Route::get('/kingMonitor/requestHistoricalMonth','requestHistoricalMonth')->name('api.v1.kingMonitor.requestHistoricalMonth'); // Obtener el historico de peticiones (month)
    Route::get('/kingMonitor/requestHistoricalQuarter','requestHistoricalQuarter')->name('api.v1.kingMonitor.requestHistoricalQuarter'); // Obtener el historico de peticiones (quarter)
    Route::get('/kingMonitor/requestHistoricalYear','requestHistoricalYear')->name('api.v1.kingMonitor.requestHistoricalYear'); // Obtener el historico de peticiones (year)
    Route::get('/kingMonitor/requestHistoricalTotal','requestHistoricalTotal')->name('api.v1.kingMonitor.requestHistoricalTotal'); // Obtener el historico de peticiones (total)

    // ---------------------------------------------------------------- ERROR HISTORICAL ----------------------------------------------------------------
    Route::get('/kingMonitor/errorHistoricalToday','errorHistoricalToday')->name('api.v1.kingMonitor.errorHistoricalToday'); // Obtener el historico de errores (today)
    Route::get('/kingMonitor/errorHistoricalWeek','errorHistoricalWeek')->name('api.v1.kingMonitor.errorHistoricalWeek'); // Obtener el historico de errores (week)
    Route::get('/kingMonitor/errorHistoricalMonth','errorHistoricalMonth')->name('api.v1.kingMonitor.errorHistoricalMonth'); // Obtener el historico de errores (month)
    Route::get('/kingMonitor/errorHistoricalQuarter','errorHistoricalQuarter')->name('api.v1.kingMonitor.errorHistoricalQuarter'); // Obtener el historico de errores (quarter)
    Route::get('/kingMonitor/errorHistoricalYear','errorHistoricalYear')->name('api.v1.kingMonitor.errorHistoricalYear'); // Obtener el historico de errores (year)
    Route::get('/kingMonitor/errorHistoricalTotal','errorHistoricalTotal')->name('api.v1.kingMonitor.errorHistoricalTotal'); // Obtener el historico de errores (total)

    // ---------------------------------------------------------------- HISTORICAL ----------------------------------------------------------------
    Route::get('/kingMonitor/historicalToday','historicalToday')->name('api.v1.kingMonitor.historicalToday'); // Obtener el historico (today)
    Route::get('/kingMonitor/historicalWeek','historicalWeek')->name('api.v1.kingMonitor.historicalWeek'); // Obtener el historico (week)
    Route::get('/kingMonitor/historicalMonth','historicalMonth')->name('api.v1.kingMonitor.historicalMonth'); // Obtener el historico (month)
    Route::get('/kingMonitor/historicalQuarter','historicalQuarter')->name('api.v1.kingMonitor.historicalQuarter'); // Obtener el historico (quarter)
    Route::get('/kingMonitor/historicalYear','historicalYear')->name('api.v1.kingMonitor.historicalYear'); // Obtener el historico (year)
    Route::get('/kingMonitor/historicalTotal','historicalTotal')->name('api.v1.kingMonitor.historicalTotal'); // Obtener el historico (total)

    // ---------------------------------------------------------------- HISTORICAL ----------------------------------------------------------------
    Route::get('/kingMonitor/userRequestHistorical/{king_user_id}','userRequestHistorical')->name('api.v1.kingMonitor.userRequestHistorical'); // Obtener el historico (total)
    Route::get('/kingMonitor/userErrorHistorical/{king_user_id}','userErrorHistorical')->name('api.v1.kingMonitor.userErrorHistorical'); // Obtener el historico (total)
    Route::get('/kingMonitor/userHistorical/{king_user_id}','userHistorical')->name('api.v1.kingMonitor.userHistorical'); // Obtener el historico (total)
    Route::get('/kingMonitor/requestHistorical','requestHistorical')->name('api.v1.kingMonitor.requestHistorical'); // Obtener el historico (total)
    Route::get('/kingMonitor/errorHistorical','errorHistorical')->name('api.v1.kingMonitor.errorHistorical'); // Obtener el historico (total)
    Route::get('/kingMonitor/historical','historical')->name('api.v1.kingMonitor.historical'); // Obtener el historico (total)

    /****************************************************************** MONITOR ******************************************************************/
    Route::post('/kingMonitor/monitor', 'monitor')->name('api.v1.kingMonitor.monitor');
});
Route::middleware(['auth:api', 'monitor-auth'])->apiResource('/kingMonitor', KingMonitorController::class)->names('api.v1.kingMonitor');

// KingMonitorError
Route::middleware(['auth:api', 'monitor-auth'])->controller(KingMonitorErrorController::class)->group(function () {
    /****************************************************************** USER ERROR STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- USER ERROR STATISTICS TODAY ----------------------------------------------------------------
    Route::get('/kingMonitorError/userErrorStatisticsToday/{king_user_id}','userErrorStatisticsToday')->name('api.v1.kingMonitorError.userErrorStatisticsToday'); // Obtener las estadisticas de errores de un usuario (today)
    Route::get('/kingMonitorError/userErrorMethodStatisticsToday/{king_user_id}','userErrorMethodStatisticsToday')->name('api.v1.kingMonitorError.userErrorMethodStatisticsToday'); // Obtener las estadisticas de errores de los metodos de un usuario (today)

    // ---------------------------------------------------------------- USER ERROR STATISTICS WEEK ----------------------------------------------------------------
    Route::get('/kingMonitorError/userErrorStatisticsWeek/{king_user_id}','userErrorStatisticsWeek')->name('api.v1.kingMonitorError.userErrorStatisticsWeek'); // Obtener las estadisticas de errores de un usuario (week)
    Route::get('/kingMonitorError/userErrorMethodStatisticsWeek/{king_user_id}','userErrorMethodStatisticsWeek')->name('api.v1.kingMonitorError.userErrorMethodStatisticsWeek'); // Obtener las estadisticas de errores de los metodos de un usuario (week)

    // ---------------------------------------------------------------- USER ERROR STATISTICS MONTH ----------------------------------------------------------------
    Route::get('/kingMonitorError/userErrorStatisticsMonth/{king_user_id}','userErrorStatisticsMonth')->name('api.v1.kingMonitorError.userErrorStatisticsMonth'); // Obtener las estadisticas de errores de un usuario (month)
    Route::get('/kingMonitorError/userErrorMethodStatisticsMonth/{king_user_id}','userErrorMethodStatisticsMonth')->name('api.v1.kingMonitorError.userErrorMethodStatisticsMonth'); // Obtener las estadisticas de errores de los metodos de un usuario (month)

    // ---------------------------------------------------------------- USER ERROR STATISTICS QUARTER ----------------------------------------------------------------
    Route::get('/kingMonitorError/userErrorStatisticsQuarter/{king_user_id}','userErrorStatisticsQuarter')->name('api.v1.kingMonitorError.userErrorStatisticsQuarter'); // Obtener las estadisticas de errores de un usuario (quarter)
    Route::get('/kingMonitorError/userErrorMethodStatisticsQuarter/{king_user_id}','userErrorMethodStatisticsQuarter')->name('api.v1.kingMonitorError.userErrorMethodStatisticsQuarter'); // Obtener las estadisticas de errores de los metodos de un usuario (quarter)

    // ---------------------------------------------------------------- USER ERROR STATISTICS YEAR ----------------------------------------------------------------
    Route::get('/kingMonitorError/userErrorStatisticsYear/{king_user_id}','userErrorStatisticsYear')->name('api.v1.kingMonitorError.userErrorStatisticsYear'); // Obtener las estadisticas de errores de un usuario (year)
    Route::get('/kingMonitorError/userErrorMethodStatisticsYear/{king_user_id}','userErrorMethodStatisticsYear')->name('api.v1.kingMonitorError.userErrorMethodStatisticsYear'); // Obtener las estadisticas de errores de los metodos de un usuario (year)

    // ---------------------------------------------------------------- USER ERROR STATISTICS TOTAL ----------------------------------------------------------------
    Route::get('/kingMonitorError/userErrorStatisticsTotal/{king_user_id}','userErrorStatisticsTotal')->name('api.v1.kingMonitorError.userErrorStatisticsTotal'); // Obtener las estadisticas de errores de un usuario (total)
    Route::get('/kingMonitorError/userErrorMethodStatisticsTotal/{king_user_id}','userErrorMethodStatisticsTotal')->name('api.v1.kingMonitorError.userErrorMethodStatisticsTotal'); // Obtener las estadisticas de errores de los metodos de un usuario (total)

    /****************************************************************** ERROR STATISTICS ******************************************************************/
    Route::get('/kingMonitorError/userErrorStatistics/{king_user_id}','userErrorStatistics')->name('api.v1.kingMonitorError.userErrorStatistics');
    Route::get('/kingMonitorError/errorStatistics','errorStatistics')->name('api.v1.kingMonitorError.errorStatistics');

    // ---------------------------------------------------------------- ERROR STATISTICS TODAY ----------------------------------------------------------------
    Route::get('/kingMonitorError/errorStatisticsToday','errorStatisticsToday')->name('api.v1.kingMonitorError.errorStatisticsToday'); // Obtener las estadisticas de errores (today)
    Route::get('/kingMonitorError/errorMethodStatisticsToday','errorMethodStatisticsToday')->name('api.v1.kingMonitorError.errorMethodStatisticsToday'); // Obtener el metodo mas comun de errores de un usuario (today)
    Route::get('/kingMonitorError/errorStatisticsFrequentUserToday','errorStatisticsFrequentUserToday')->name('api.v1.kingMonitorError.errorStatisticsFrequentUserToday'); // Obtener el usuario mas comun de errores (today)

    // ---------------------------------------------------------------- ERROR STATISTICS WEEK ----------------------------------------------------------------
    Route::get('/kingMonitorError/errorStatisticsWeek','errorStatisticsWeek')->name('api.v1.kingMonitorError.errorStatisticsWeek'); // Obtener las estadisticas de errores (week)
    Route::get('/kingMonitorError/errorMethodStatisticsWeek','errorMethodStatisticsWeek')->name('api.v1.kingMonitorError.errorMethodStatisticsWeek'); // Obtener el metodo mas comun de errores de un usuario (week)
    Route::get('/kingMonitorError/errorStatisticsFrequentUserWeek','errorStatisticsFrequentUserWeek')->name('api.v1.kingMonitorError.errorStatisticsFrequentUserWeek'); // Obtener el usuario mas comun de errores (week)

    // ---------------------------------------------------------------- ERROR STATISTICS MONTH ----------------------------------------------------------------
    Route::get('/kingMonitorError/errorStatisticsMonth','errorStatisticsMonth')->name('api.v1.kingMonitorError.errorStatisticsMonth'); // Obtener las estadisticas de errores (month)
    Route::get('/kingMonitorError/errorMethodStatisticsMonth','errorMethodStatisticsMonth')->name('api.v1.kingMonitorError.errorMethodStatisticsMonth'); // Obtener el metodo mas comun de errores de un usuario (month)
    Route::get('/kingMonitorError/errorStatisticsFrequentUserMonth','errorStatisticsFrequentUserMonth')->name('api.v1.kingMonitorError.errorStatisticsFrequentUserMonth'); // Obtener el usuario mas comun de errores (month)

    // ---------------------------------------------------------------- ERROR STATISTICS QUARTER ----------------------------------------------------------------
    Route::get('/kingMonitorError/errorStatisticsQuarter','errorStatisticsQuarter')->name('api.v1.kingMonitorError.errorStatisticsQuarter'); // Obtener las estadisticas de errores (quarter)
    Route::get('/kingMonitorError/errorMethodStatisticsQuarter','errorMethodStatisticsQuarter')->name('api.v1.kingMonitorError.errorMethodStatisticsQuarter'); // Obtener el metodo mas comun de errores de un usuario (quarter)
    Route::get('/kingMonitorError/errorStatisticsFrequentUserQuarter','errorStatisticsFrequentUserQuarter')->name('api.v1.kingMonitorError.errorStatisticsFrequentUserQuarter'); // Obtener el usuario mas comun de errores (quarter)

    // ---------------------------------------------------------------- ERROR STATISTICS YEAR ----------------------------------------------------------------
    Route::get('/kingMonitorError/errorStatisticsYear','errorStatisticsYear')->name('api.v1.kingMonitorError.errorStatisticsYear'); // Obtener las estadisticas de errores (year)
    Route::get('/kingMonitorError/errorMethodStatisticsYear','errorMethodStatisticsYear')->name('api.v1.kingMonitorError.errorMethodStatisticsYear'); // Obtener el metodo mas comun de errores de un usuario (year)
    Route::get('/kingMonitorError/errorStatisticsFrequentUserYear','errorStatisticsFrequentUserYear')->name('api.v1.kingMonitorError.errorStatisticsFrequentUserYear'); // Obtener el usuario mas comun de errores (year)

    // ---------------------------------------------------------------- ERROR STATISTICS TOTAL ----------------------------------------------------------------
    Route::get('/kingMonitorError/errorStatisticsTotal','errorStatisticsTotal')->name('api.v1.kingMonitorError.errorStatisticsTotal'); // Obtener las estadisticas de errores (total)
    Route::get('/kingMonitorError/errorMethodStatisticsTotal','errorMethodStatisticsTotal')->name('api.v1.kingMonitorError.errorMethodStatisticsTotal'); // Obtener el metodo mas comun de errores de un usuario (total)
    Route::get('/kingMonitorError/errorStatisticsFrequentUserTotal','errorStatisticsFrequentUserTotal')->name('api.v1.kingMonitorError.errorStatisticsFrequentUserTotal'); // Obtener el usuario mas comun de errores (total)

    /****************************************************************** STATISTICS ENDPOINT ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS ENDPOINT TOTAL ----------------------------------------------------------------
    Route::get('/kingMonitorError/errorStatisticsEndpointTotal','errorStatisticsEndpointTotal')->name('api.v1.kingMonitorError.errorStatisticsEndpointTotal'); // Obtener las estadisticas de los endpoints

    /****************************************************************** USER HISTORICAL ******************************************************************/
    // ---------------------------------------------------------------- USER HISTORICAL ----------------------------------------------------------------
    Route::get('/kingMonitorError/userErrorHistoricalToday/{king_user_id}','userErrorHistoricalToday')->name('api.v1.kingMonitorError.userErrorHistoricalToday'); // Obtener el historico de errores del usuario (today)
    Route::get('/kingMonitorError/userErrorHistoricalWeek/{king_user_id}','userErrorHistoricalWeek')->name('api.v1.kingMonitorError.userErrorHistoricalWeek'); // Obtener el historico de errores del usuario (week)
    Route::get('/kingMonitorError/userErrorHistoricalMonth/{king_user_id}','userErrorHistoricalMonth')->name('api.v1.kingMonitorError.userErrorHistoricalMonth'); // Obtener el historico de errores del usuario (month)
    Route::get('/kingMonitorError/userErrorHistoricalQuarter/{king_user_id}','userErrorHistoricalQuarter')->name('api.v1.kingMonitorError.userErrorHistoricalQuarter'); // Obtener el historico de errores del usuario (quarter)
    Route::get('/kingMonitorError/userErrorHistoricalYear/{king_user_id}','userErrorHistoricalYear')->name('api.v1.kingMonitorError.userErrorHistoricalYear'); // Obtener el historico de errores del usuario (year)
    Route::get('/kingMonitorError/userErrorHistoricalTotal/{king_user_id}','userErrorHistoricalTotal')->name('api.v1.kingMonitorError.userErrorHistoricalTotal'); // Obtener el historico de errores del usuario (total)

    /****************************************************************** HISTORICAL ******************************************************************/
    // ---------------------------------------------------------------- HISTORICAL ----------------------------------------------------------------
    Route::get('/kingMonitorError/errorHistoricalToday','errorHistoricalToday')->name('api.v1.kingMonitorError.errorHistoricalToday'); // Obtener el historico de errores (today)
    Route::get('/kingMonitorError/errorHistoricalWeek','errorHistoricalWeek')->name('api.v1.kingMonitorError.errorHistoricalWeek'); // Obtener el historico de errores (week)
    Route::get('/kingMonitorError/errorHistoricalMonth','errorHistoricalMonth')->name('api.v1.kingMonitorError.errorHistoricalMonth'); // Obtener el historico de errores (month)
    Route::get('/kingMonitorError/errorHistoricalQuarter','errorHistoricalQuarter')->name('api.v1.kingMonitorError.errorHistoricalQuarter'); // Obtener el historico de errores (quarter)
    Route::get('/kingMonitorError/errorHistoricalYear','errorHistoricalYear')->name('api.v1.kingMonitorError.errorHistoricalYear'); // Obtener el historico de errores (year)
    Route::get('/kingMonitorError/errorHistoricalTotal','errorHistoricalTotal')->name('api.v1.kingMonitorError.errorHistoricalTotal'); // Obtener el historico de errores (total)

    // ---------------------------------------------------------------- HISTORICAL ----------------------------------------------------------------
    Route::get('/kingMonitorError/userErrorHistorical/{king_user_id}','userErrorHistorical')->name('api.v1.kingMonitorError.userErrorHistorical'); // Obtener el historico de errores del usuario (total)
    Route::get('/kingMonitorError/errorHistorical','errorHistorical')->name('api.v1.kingMonitorError.errorHistorical'); // Obtener el historico de errores (total)

    /****************************************************************** MONITOR ******************************************************************/
    Route::get('/kingMonitorError/monitor', 'monitor')->name('api.v1.kingMonitorError.monitor');
});
Route::middleware(['auth:api', 'monitor-auth'])->apiResource('/kingMonitorError', KingMonitorErrorController::class)->names('api.v1.kingMonitorError');

// KingMonitorRequest
Route::middleware(['auth:api', 'monitor-auth'])->controller(KingMonitorRequestController::class)->group(function () {
    /****************************************************************** USER REQUEST STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- USER REQUEST STATISTICS TODAY ----------------------------------------------------------------
    Route::get('/kingMonitorRequest/userRequestStatisticsToday/{king_user_id}','userRequestStatisticsToday')->name('api.v1.kingMonitorRequest.userRequestStatisticsToday'); // Obtener las estadisticas de peticiones de un usuario (today)
    Route::get('/kingMonitorRequest/userRequestMethodStatisticsToday/{king_user_id}','userRequestMethodStatisticsToday')->name('api.v1.kingMonitorRequest.userRequestMethodStatisticsToday'); // Obtener las estadisticas de peticiones de los metodos de un usuario (today)

    // ---------------------------------------------------------------- USER REQUEST STATISTICS WEEK ----------------------------------------------------------------
    Route::get('/kingMonitorRequest/userRequestStatisticsWeek/{king_user_id}','userRequestStatisticsWeek')->name('api.v1.kingMonitorRequest.userRequestStatisticsWeek'); // Obtener las estadisticas de peticiones de un usuario (week)
    Route::get('/kingMonitorRequest/userRequestMethodStatisticsWeek/{king_user_id}','userRequestMethodStatisticsWeek')->name('api.v1.kingMonitorRequest.userRequestMethodStatisticsWeek'); // Obtener las estadisticas de peticiones de los metodos de un usuario (week)

    // ---------------------------------------------------------------- USER REQUEST STATISTICS MONTH ----------------------------------------------------------------
    Route::get('/kingMonitorRequest/userRequestStatisticsMonth/{king_user_id}','userRequestStatisticsMonth')->name('api.v1.kingMonitorRequest.userRequestStatisticsMonth'); // Obtener las estadisticas de peticiones de un usuario (month)
    Route::get('/kingMonitorRequest/userRequestMethodStatisticsMonth/{king_user_id}','userRequestMethodStatisticsMonth')->name('api.v1.kingMonitorRequest.userRequestMethodStatisticsMonth'); // Obtener las estadisticas de peticiones de los metodos de un usuario (month)

    // ---------------------------------------------------------------- USER REQUEST STATISTICS QUARTER ----------------------------------------------------------------
    Route::get('/kingMonitorRequest/userRequestStatisticsQuarter/{king_user_id}','userRequestStatisticsQuarter')->name('api.v1.kingMonitorRequest.userRequestStatisticsQuarter'); // Obtener las estadisticas de peticiones de un usuario (quarter)
    Route::get('/kingMonitorRequest/userRequestMethodStatisticsQuarter/{king_user_id}','userRequestMethodStatisticsQuarter')->name('api.v1.kingMonitorRequest.userRequestMethodStatisticsQuarter'); // Obtener las estadisticas de peticiones de los metodos de un usuario (quarter)

    // ---------------------------------------------------------------- USER REQUEST STATISTICS YEAR ----------------------------------------------------------------
    Route::get('/kingMonitorRequest/userRequestStatisticsYear/{king_user_id}','userRequestStatisticsYear')->name('api.v1.kingMonitorRequest.userRequestStatisticsYear'); // Obtener las estadisticas de peticiones de un usuario (year)
    Route::get('/kingMonitorRequest/userRequestMethodStatisticsYear/{king_user_id}','userRequestMethodStatisticsYear')->name('api.v1.kingMonitorRequest.userRequestMethodStatisticsYear'); // Obtener las estadisticas de peticiones de los metodos de un usuario (year)

    // ---------------------------------------------------------------- USER REQUEST STATISTICS TOTAL ----------------------------------------------------------------
    Route::get('/kingMonitorRequest/userRequestStatisticsTotal/{king_user_id}','userRequestStatisticsTotal')->name('api.v1.kingMonitorRequest.userRequestStatisticsTotal'); // Obtener las estadisticas de peticiones de un usuario (total)
    Route::get('/kingMonitorRequest/userRequestMethodStatisticsTotal/{king_user_id}','userRequestMethodStatisticsTotal')->name('api.v1.kingMonitorRequest.userRequestMethodStatisticsTotal'); // Obtener las estadisticas de peticiones de los metodos de un usuario (total)

    /****************************************************************** REQUEST STATISTICS ******************************************************************/
    Route::get('/kingMonitorRequest/userRequestStatistics/{king_user_id}','userRequestStatistics')->name('api.v1.kingMonitorRequest.userRequestStatistics');
    Route::get('/kingMonitorRequest/requestStatistics','requestStatistics')->name('api.v1.kingMonitorRequest.requestStatistics');

    // ---------------------------------------------------------------- REQUEST STATISTICS TODAY ----------------------------------------------------------------
    Route::get('/kingMonitorRequest/requestStatisticsToday','requestStatisticsToday')->name('api.v1.kingMonitorRequest.requestStatisticsToday'); // Obtener las estadisticas de peticiones (today)
    Route::get('/kingMonitorRequest/requestMethodStatisticsToday','requestMethodStatisticsToday')->name('api.v1.kingMonitorRequest.requestMethodStatisticsToday'); // Obtener el metodo mas comun de peticiones de un usuario (today)
    Route::get('/kingMonitorRequest/requestStatisticsFrequentUserToday','requestStatisticsFrequentUserToday')->name('api.v1.kingMonitorRequest.requestStatisticsFrequentUserToday'); // Obtener el usuario mas comun de peticiones (today)

    // ---------------------------------------------------------------- REQUEST STATISTICS WEEK ----------------------------------------------------------------
    Route::get('/kingMonitorRequest/requestStatisticsWeek','requestStatisticsWeek')->name('api.v1.kingMonitorRequest.requestStatisticsWeek'); // Obtener las estadisticas de peticiones (week)
    Route::get('/kingMonitorRequest/requestMethodStatisticsWeek','requestMethodStatisticsWeek')->name('api.v1.kingMonitorRequest.requestMethodStatisticsWeek'); // Obtener el metodo mas comun de peticiones de un usuario (week)
    Route::get('/kingMonitorRequest/requestStatisticsFrequentUserWeek','requestStatisticsFrequentUserWeek')->name('api.v1.kingMonitorRequest.requestStatisticsFrequentUserWeek'); // Obtener el usuario mas comun de peticiones (week)

    // ---------------------------------------------------------------- REQUEST STATISTICS MONTH ----------------------------------------------------------------
    Route::get('/kingMonitorRequest/requestStatisticsMonth','requestStatisticsMonth')->name('api.v1.kingMonitorRequest.requestStatisticsMonth'); // Obtener las estadisticas de peticiones (month)
    Route::get('/kingMonitorRequest/requestMethodStatisticsMonth','requestMethodStatisticsMonth')->name('api.v1.kingMonitorRequest.requestMethodStatisticsMonth'); // Obtener el metodo mas comun de peticiones de un usuario (month)
    Route::get('/kingMonitorRequest/requestStatisticsFrequentUserMonth','requestStatisticsFrequentUserMonth')->name('api.v1.kingMonitorRequest.requestStatisticsFrequentUserMonth'); // Obtener el usuario mas comun de peticiones (month)

    // ---------------------------------------------------------------- REQUEST STATISTICS QUARTER ----------------------------------------------------------------
    Route::get('/kingMonitorRequest/requestStatisticsQuarter','requestStatisticsQuarter')->name('api.v1.kingMonitorRequest.requestStatisticsQuarter'); // Obtener las estadisticas de peticiones (quarter)
    Route::get('/kingMonitorRequest/requestMethodStatisticsQuarter','requestMethodStatisticsQuarter')->name('api.v1.kingMonitorRequest.requestMethodStatisticsQuarter'); // Obtener el metodo mas comun de peticiones de un usuario (quarter)
    Route::get('/kingMonitorRequest/requestStatisticsFrequentUserQuarter','requestStatisticsFrequentUserQuarter')->name('api.v1.kingMonitorRequest.requestStatisticsFrequentUserQuarter'); // Obtener el usuario mas comun de peticiones (quarter)

    // ---------------------------------------------------------------- REQUEST STATISTICS YEAR ----------------------------------------------------------------
    Route::get('/kingMonitorRequest/requestStatisticsYear','requestStatisticsYear')->name('api.v1.kingMonitorRequest.requestStatisticsYear'); // Obtener las estadisticas de peticiones (year)
    Route::get('/kingMonitorRequest/requestMethodStatisticsYear','requestMethodStatisticsYear')->name('api.v1.kingMonitorRequest.requestMethodStatisticsYear'); // Obtener el metodo mas comun de peticiones de un usuario (year)
    Route::get('/kingMonitorRequest/requestStatisticsFrequentUserYear','requestStatisticsFrequentUserYear')->name('api.v1.kingMonitorRequest.requestStatisticsFrequentUserYear'); // Obtener el usuario mas comun de peticiones (year)

    // ---------------------------------------------------------------- REQUEST STATISTICS TOTAL ----------------------------------------------------------------
    Route::get('/kingMonitorRequest/requestStatisticsTotal','requestStatisticsTotal')->name('api.v1.kingMonitorRequest.requestStatisticsTotal'); // Obtener las estadisticas de peticiones (total)
    Route::get('/kingMonitorRequest/requestMethodStatisticsTotal','requestMethodStatisticsTotal')->name('api.v1.kingMonitorRequest.requestMethodStatisticsTotal'); // Obtener el metodo mas comun de peticiones de un usuario (total)
    Route::get('/kingMonitorRequest/requestStatisticsFrequentUserTotal','requestStatisticsFrequentUserTotal')->name('api.v1.kingMonitorRequest.requestStatisticsFrequentUserTotal'); // Obtener el usuario mas comun de peticiones (total)

    /****************************************************************** STATISTICS ENDPOINT ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS ENDPOINT TOTAL ----------------------------------------------------------------
    Route::get('/kingMonitorRequest/requestStatisticsEndpointTotal','requestStatisticsEndpointTotal')->name('api.v1.kingMonitorRequest.requestStatisticsEndpointTotal'); // Obtener las estadisticas de peticiones de los endpoints

    /****************************************************************** USER HISTORICAL ******************************************************************/
    // ---------------------------------------------------------------- USER REQUEST HISTORICAL ----------------------------------------------------------------
    Route::get('/kingMonitorRequest/userRequestHistoricalToday/{king_user_id}','userRequestHistoricalToday')->name('api.v1.kingMonitorRequest.userRequestHistoricalToday'); // Obtener el historico de peticiones del usuario (today)
    Route::get('/kingMonitorRequest/userRequestHistoricalWeek/{king_user_id}','userRequestHistoricalWeek')->name('api.v1.kingMonitorRequest.userRequestHistoricalWeek'); // Obtener el historico de peticiones del usuario (week)
    Route::get('/kingMonitorRequest/userRequestHistoricalMonth/{king_user_id}','userRequestHistoricalMonth')->name('api.v1.kingMonitorRequest.userRequestHistoricalMonth'); // Obtener el historico de peticiones del usuario (month)
    Route::get('/kingMonitorRequest/userRequestHistoricalQuarter/{king_user_id}','userRequestHistoricalQuarter')->name('api.v1.kingMonitorRequest.userRequestHistoricalQuarter'); // Obtener el historico de peticiones del usuario (quarter)
    Route::get('/kingMonitorRequest/userRequestHistoricalYear/{king_user_id}','userRequestHistoricalYear')->name('api.v1.kingMonitorRequest.userRequestHistoricalYear'); // Obtener el historico de peticiones del usuario (year)
    Route::get('/kingMonitorRequest/userRequestHistoricalTotal/{king_user_id}','userRequestHistoricalTotal')->name('api.v1.kingMonitorRequest.userRequestHistoricalTotal'); // Obtener el historico de peticiones del usuario (total)

    /****************************************************************** HISTORICAL ******************************************************************/
    // ---------------------------------------------------------------- REQUEST HISTORICAL ----------------------------------------------------------------
    Route::get('/kingMonitorRequest/requestHistoricalToday','requestHistoricalToday')->name('api.v1.kingMonitorRequest.requestHistoricalToday'); // Obtener el historico de peticiones (today)
    Route::get('/kingMonitorRequest/requestHistoricalWeek','requestHistoricalWeek')->name('api.v1.kingMonitorRequest.requestHistoricalWeek'); // Obtener el historico de peticiones (week)
    Route::get('/kingMonitorRequest/requestHistoricalMonth','requestHistoricalMonth')->name('api.v1.kingMonitorRequest.requestHistoricalMonth'); // Obtener el historico de peticiones (month)
    Route::get('/kingMonitorRequest/requestHistoricalQuarter','requestHistoricalQuarter')->name('api.v1.kingMonitorRequest.requestHistoricalQuarter'); // Obtener el historico de peticiones (quarter)
    Route::get('/kingMonitorRequest/requestHistoricalYear','requestHistoricalYear')->name('api.v1.kingMonitorRequest.requestHistoricalYear'); // Obtener el historico de peticiones (year)
    Route::get('/kingMonitorRequest/requestHistoricalTotal','requestHistoricalTotal')->name('api.v1.kingMonitorRequest.requestHistoricalTotal'); // Obtener el historico de peticiones (total)

    // ---------------------------------------------------------------- HISTORICAL ----------------------------------------------------------------
    Route::get('/kingMonitorRequest/userRequestHistorical/{king_user_id}','userRequestHistorical')->name('api.v1.kingMonitorRequest.userRequestHistorical'); // Obtener el historico de peticiones del usuario (total)
    Route::get('/kingMonitorRequest/requestHistorical','requestHistorical')->name('api.v1.kingMonitorRequest.requestHistorical'); // Obtener el historico de peticiones (total)

    /****************************************************************** MONITOR ******************************************************************/
    Route::get('/kingMonitorRequest/monitor', 'monitor')->name('api.v1.kingMonitorRequest.monitor');
});

// KingMonitorUserExceeded
Route::middleware(['auth:api', 'monitor-auth'])->controller(KingMonitorUserExceededController::class)->group(function () {
    Route::get('/kingMonitorUserExceeded/limit','limit')->name('api.v1.kingMonitorUserExceeded.limit');

    /****************************************************************** USER ******************************************************************/
    // ---------------------------------------------------------------- USER REQUEST EXCEEDED ----------------------------------------------------------------
    Route::get('/kingMonitorUserExceeded/userExceededToday','userExceededToday')->name('api.v1.kingMonitorUserExceeded.userExceededToday'); // Obtener los usuarios que excedieron el limite de peticiones (today)
    Route::get('/kingMonitorUserExceeded/userExceededWeek','userExceededWeek')->name('api.v1.kingMonitorUserExceeded.userExceededWeek'); // Obtener los usuarios que excedieron el limite de peticiones (week)
    Route::get('/kingMonitorUserExceeded/userExceededMonth','userExceededMonth')->name('api.v1.kingMonitorUserExceeded.userExceededMonth'); // Obtener los usuarios que excedieron el limite de peticiones (month)
    Route::get('/kingMonitorUserExceeded/userExceededQuarter','userExceededQuarter')->name('api.v1.kingMonitorUserExceeded.userExceededQuarter'); // Obtener los usuarios que excedieron el limite de peticiones (quarter)
    Route::get('/kingMonitorUserExceeded/userExceededYear','userExceededYear')->name('api.v1.kingMonitorUserExceeded.userExceededYear'); // Obtener los usuarios que excedieron el limite de peticiones (year)
    Route::get('/kingMonitorUserExceeded/userExceededTotal','userExceededTotal')->name('api.v1.kingMonitorUserExceeded.userExceededTotal'); // Obtener los usuarios que excedieron el limite de peticiones (total)

    /****************************************************************** TOKEN ******************************************************************/
    // ---------------------------------------------------------------- TOKEN REQUEST EXCEEDED ----------------------------------------------------------------
    Route::get('/kingMonitorUserExceeded/tokenExceededToday','tokenExceededToday')->name('api.v1.kingMonitorUserExceeded.tokenExceededToday'); // Obtener los tokens que excedieron el limite de peticiones (today)
    Route::get('/kingMonitorUserExceeded/tokenExceededWeek','tokenExceededWeek')->name('api.v1.kingMonitorUserExceeded.tokenExceededWeek'); // Obtener los tokens que excedieron el limite de peticiones (week)
    Route::get('/kingMonitorUserExceeded/tokenExceededMonth','tokenExceededMonth')->name('api.v1.kingMonitorUserExceeded.tokenExceededMonth'); // Obtener los tokens que excedieron el limite de peticiones (month)
    Route::get('/kingMonitorUserExceeded/tokenExceededQuarter','tokenExceededQuarter')->name('api.v1.kingMonitorUserExceeded.tokenExceededQuarter'); // Obtener los tokens que excedieron el limite de peticiones (quarter)
    Route::get('/kingMonitorUserExceeded/tokenExceededYear','tokenExceededYear')->name('api.v1.kingMonitorUserExceeded.tokenExceededYear'); // Obtener los tokens que excedieron el limite de peticiones (year)
    Route::get('/kingMonitorUserExceeded/tokenExceededTotal','tokenExceededTotal')->name('api.v1.kingMonitorUserExceeded.tokenExceededTotal'); // Obtener los tokens que excedieron el limite de peticiones (total)

    /****************************************************************** IP ******************************************************************/
    // ---------------------------------------------------------------- IP REQUEST EXCEEDED ----------------------------------------------------------------
    Route::get('/kingMonitorUserExceeded/ipExceededToday','ipExceededToday')->name('api.v1.kingMonitorUserExceeded.ipExceededToday'); // Obtener las IP que excedieron el limite de peticiones (today)
    Route::get('/kingMonitorUserExceeded/ipExceededWeek','ipExceededWeek')->name('api.v1.kingMonitorUserExceeded.ipExceededWeek'); // Obtener las IP que excedieron el limite de peticiones (week)
    Route::get('/kingMonitorUserExceeded/ipExceededMonth','ipExceededMonth')->name('api.v1.kingMonitorUserExceeded.ipExceededMonth'); // Obtener las IP que excedieron el limite de peticiones (month)
    Route::get('/kingMonitorUserExceeded/ipExceededQuarter','ipExceededQuarter')->name('api.v1.kingMonitorUserExceeded.ipExceededQuarter'); // Obtener las IP que excedieron el limite de peticiones (quarter)
    Route::get('/kingMonitorUserExceeded/ipExceededYear','ipExceededYear')->name('api.v1.kingMonitorUserExceeded.ipExceededYear'); // Obtener las IP que excedieron el limite de peticiones (year)
    Route::get('/kingMonitorUserExceeded/ipExceededTotal','ipExceededTotal')->name('api.v1.kingMonitorUserExceeded.ipExceededTotal'); // Obtener las IP que excedieron el limite de peticiones (total)

    /****************************************************************** USER STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- USER STATISTICS TODAY  ----------------------------------------------------------------
    Route::get('/kingMonitorUserExceeded/userStatisticsToday/{king_user_id}','userStatisticsToday')->name('api.v1.kingMonitorUserExceeded.userStatisticsToday'); // Obtener la estadistica del usuario (today)
    Route::get('/kingMonitorUserExceeded/userRequestStatisticsToday/{king_user_id}','userRequestStatisticsToday')->name('api.v1.kingMonitorUserExceeded.userRequestStatisticsToday'); // Obtener la estadistica de peticiones del usuario (today)
    Route::get('/kingMonitorUserExceeded/userErrorStatisticsToday/{king_user_id}','userErrorStatisticsToday')->name('api.v1.kingMonitorUserExceeded.userErrorStatisticsToday'); // Obtener la estadistica de errores del usuario (today)

    // ---------------------------------------------------------------- USER STATISTICS WEEK  ----------------------------------------------------------------
    Route::get('/kingMonitorUserExceeded/userStatisticsWeek/{king_user_id}','userStatisticsWeek')->name('api.v1.kingMonitorUserExceeded.userStatisticsWeek'); // Obtener la estadistica del usuario (week)
    Route::get('/kingMonitorUserExceeded/userRequestStatisticsWeek/{king_user_id}','userRequestStatisticsWeek')->name('api.v1.kingMonitorUserExceeded.userRequestStatisticsWeek'); // Obtener la estadistica de peticiones del usuario (week)
    Route::get('/kingMonitorUserExceeded/userErrorStatisticsWeek/{king_user_id}','userErrorStatisticsWeek')->name('api.v1.kingMonitorUserExceeded.userErrorStatisticsWeek'); // Obtener la estadistica de errores del usuario (week)

    // ---------------------------------------------------------------- USER STATISTICS MONTH  ----------------------------------------------------------------
    Route::get('/kingMonitorUserExceeded/userStatisticsMonth/{king_user_id}','userStatisticsMonth')->name('api.v1.kingMonitorUserExceeded.userStatisticsMonth'); // Obtener la estadistica del usuario (month)
    Route::get('/kingMonitorUserExceeded/userRequestStatisticsMonth/{king_user_id}','userRequestStatisticsMonth')->name('api.v1.kingMonitorUserExceeded.userRequestStatisticsMonth'); // Obtener la estadistica de peticiones del usuario (month)
    Route::get('/kingMonitorUserExceeded/userErrorStatisticsMonth/{king_user_id}','userErrorStatisticsMonth')->name('api.v1.kingMonitorUserExceeded.userErrorStatisticsMonth'); // Obtener la estadistica de errores del usuario (month)

    // ---------------------------------------------------------------- USER STATISTICS QUARTER  ----------------------------------------------------------------
    Route::get('/kingMonitorUserExceeded/userStatisticsQuarter/{king_user_id}','userStatisticsQuarter')->name('api.v1.kingMonitorUserExceeded.userStatisticsQuarter'); // Obtener la estadistica del usuario (quarter)
    Route::get('/kingMonitorUserExceeded/userRequestStatisticsQuarter/{king_user_id}','userRequestStatisticsQuarter')->name('api.v1.kingMonitorUserExceeded.userRequestStatisticsQuarter'); // Obtener la estadistica de peticiones del usuario (quarter)
    Route::get('/kingMonitorUserExceeded/userErrorStatisticsQuarter/{king_user_id}','userErrorStatisticsQuarter')->name('api.v1.kingMonitorUserExceeded.userErrorStatisticsQuarter'); // Obtener la estadistica de errores del usuario (quarter)

    // ---------------------------------------------------------------- USER STATISTICS YEAR  ----------------------------------------------------------------
    Route::get('/kingMonitorUserExceeded/userStatisticsYear/{king_user_id}','userStatisticsYear')->name('api.v1.kingMonitorUserExceeded.userStatisticsYear'); // Obtener la estadistica del usuario (year)
    Route::get('/kingMonitorUserExceeded/userRequestStatisticsYear/{king_user_id}','userRequestStatisticsYear')->name('api.v1.kingMonitorUserExceeded.userRequestStatisticsYear'); // Obtener la estadistica de peticiones del usuario (year)
    Route::get('/kingMonitorUserExceeded/userErrorStatisticsYear/{king_user_id}','userErrorStatisticsYear')->name('api.v1.kingMonitorUserExceeded.userErrorStatisticsYear'); // Obtener la estadistica de errores del usuario (year)

    // ---------------------------------------------------------------- USER STATISTICS TOTAL  ----------------------------------------------------------------
    Route::get('/kingMonitorUserExceeded/userStatisticsTotal/{king_user_id}','userStatisticsTotal')->name('api.v1.kingMonitorUserExceeded.userStatisticsTotal'); // Obtener la estadistica del usuario (total)
    Route::get('/kingMonitorUserExceeded/userRequestStatisticsTotal/{king_user_id}','userRequestStatisticsTotal')->name('api.v1.kingMonitorUserExceeded.userRequestStatisticsTotal'); // Obtener la estadistica de peticiones del usuario (total)
    Route::get('/kingMonitorUserExceeded/userErrorStatisticsTotal/{king_user_id}','userErrorStatisticsTotal')->name('api.v1.kingMonitorUserExceeded.userErrorStatisticsTotal'); // Obtener la estadistica de errores del usuario (total)

    // ---------------------------------------------------------------- USER STATISTICS ----------------------------------------------------------------
    Route::get('/kingMonitorUserExceeded/userStatistics/{king_user_id}','userStatistics')->name('api.v1.kingMonitorUserExceeded.userStatistics'); // Obtener las estadisticas del usuario
    Route::get('/kingMonitorUserExceeded/userRequestStatistics/{king_user_id}','userRequestStatistics')->name('api.v1.kingMonitorUserExceeded.userRequestStatistics'); // Obtener las estadisticas de peticiones del usuario
    Route::get('/kingMonitorUserExceeded/userErrorStatistics/{king_user_id}','userErrorStatistics')->name('api.v1.kingMonitorUserExceeded.userErrorStatistics'); // Obtener las estadisticas de errrores del usuario

    /****************************************************************** STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS TODAY  ----------------------------------------------------------------
    Route::get('/kingMonitorUserExceeded/statisticsToday','statisticsToday')->name('api.v1.kingMonitorUserExceeded.statisticsToday'); // Obtener la estadistica (today)
    Route::get('/kingMonitorUserExceeded/requestStatisticsToday','requestStatisticsToday')->name('api.v1.kingMonitorUserExceeded.requestStatisticsToday'); // Obtener la estadistica de peticiones (today)
    Route::get('/kingMonitorUserExceeded/errorStatisticsToday','errorStatisticsToday')->name('api.v1.kingMonitorUserExceeded.errorStatisticsToday'); // Obtener la estadistica de errores (today)

    // ---------------------------------------------------------------- STATISTICS WEEK  ----------------------------------------------------------------
    Route::get('/kingMonitorUserExceeded/statisticsWeek','statisticsWeek')->name('api.v1.kingMonitorUserExceeded.statisticsWeek'); // Obtener la estadistica (week)
    Route::get('/kingMonitorUserExceeded/requestStatisticsWeek','requestStatisticsWeek')->name('api.v1.kingMonitorUserExceeded.requestStatisticsWeek'); // Obtener la estadistica de peticiones (week)
    Route::get('/kingMonitorUserExceeded/errorStatisticsWeek','errorStatisticsWeek')->name('api.v1.kingMonitorUserExceeded.errorStatisticsWeek'); // Obtener la estadistica de errores (week)

    // ---------------------------------------------------------------- STATISTICS MONTH  ----------------------------------------------------------------
    Route::get('/kingMonitorUserExceeded/statisticsMonth','statisticsMonth')->name('api.v1.kingMonitorUserExceeded.statisticsMonth'); // Obtener la estadistica (month)
    Route::get('/kingMonitorUserExceeded/requestStatisticsMonth','requestStatisticsMonth')->name('api.v1.kingMonitorUserExceeded.requestStatisticsMonth'); // Obtener la estadistica de peticiones (month)
    Route::get('/kingMonitorUserExceeded/errorStatisticsMonth','errorStatisticsMonth')->name('api.v1.kingMonitorUserExceeded.errorStatisticsMonth'); // Obtener la estadistica de errores (month)

    // ---------------------------------------------------------------- STATISTICS QUARTER  ----------------------------------------------------------------
    Route::get('/kingMonitorUserExceeded/statisticsQuarter','statisticsQuarter')->name('api.v1.kingMonitorUserExceeded.statisticsQuarter'); // Obtener la estadistica (quarter)
    Route::get('/kingMonitorUserExceeded/requestStatisticsQuarter','requestStatisticsQuarter')->name('api.v1.kingMonitorUserExceeded.requestStatisticsQuarter'); // Obtener la estadistica de peticiones (quarter)
    Route::get('/kingMonitorUserExceeded/errorStatisticsQuarter','errorStatisticsQuarter')->name('api.v1.kingMonitorUserExceeded.errorStatisticsQuarter'); // Obtener la estadistica de errores (quarter)

    // ---------------------------------------------------------------- STATISTICS YEAR  ----------------------------------------------------------------
    Route::get('/kingMonitorUserExceeded/statisticsYear','statisticsYear')->name('api.v1.kingMonitorUserExceeded.statisticsYear'); // Obtener la estadistica (year)
    Route::get('/kingMonitorUserExceeded/requestStatisticsYear','requestStatisticsYear')->name('api.v1.kingMonitorUserExceeded.requestStatisticsYear'); // Obtener la estadistica de peticiones (year)
    Route::get('/kingMonitorUserExceeded/errorStatisticsYear','errorStatisticsYear')->name('api.v1.kingMonitorUserExceeded.errorStatisticsYear'); // Obtener la estadistica de errores (year)

    // ---------------------------------------------------------------- STATISTICS TOTAL  ----------------------------------------------------------------
    Route::get('/kingMonitorUserExceeded/statisticsTotal','statisticsTotal')->name('api.v1.kingMonitorUserExceeded.statisticsTotal'); // Obtener la estadistica (total)
    Route::get('/kingMonitorUserExceeded/requestStatisticsTotal','requestStatisticsTotal')->name('api.v1.kingMonitorUserExceeded.requestStatisticsTotal'); // Obtener la estadistica de peticiones (total)
    Route::get('/kingMonitorUserExceeded/errorStatisticsTotal','errorStatisticsTotal')->name('api.v1.kingMonitorUserExceeded.errorStatisticsTotal'); // Obtener la estadistica de errores (total)

    // ---------------------------------------------------------------- STATISTICS  ----------------------------------------------------------------
    Route::get('/kingMonitorUserExceeded/statistics','statistics')->name('api.v1.kingMonitorUserExceeded.statistics'); // Obtener la estadistica
    Route::get('/kingMonitorUserExceeded/requestStatistics','requestStatistics')->name('api.v1.kingMonitorUserExceeded.requestStatistics'); // Obtener la estadistica de peticiones
    Route::get('/kingMonitorUserExceeded/errorStatistics','errorStatistics')->name('api.v1.kingMonitorUserExceeded.errorStatistics'); // Obtener la estadistica de errores
});
Route::middleware(['auth:api', 'monitor-auth'])->apiResource('/kingMonitorUserExceeded', KingMonitorUserExceededController::class)->names('api.v1.kingMonitorUserExceeded');
