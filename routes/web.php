<?php

use Illuminate\Support\Facades\Route;
use ByCarmona141\KingMonitor\Http\Controllers\WEB\KingMonitorController;

Route::get('/monitor/errors', [KingMonitorController::class, 'errors'])->name('monitor.errors');
Route::get('/monitor/requests', [KingMonitorController::class, 'requests'])->name('monitor.requests');
Route::get('/monitor/{king_user_id}/detailed', [KingMonitorController::class, 'show_detailed'])->name('monitor.show_detailed');
Route::get('/monitor/{king_user_id}', [KingMonitorController::class, 'show'])->name('monitor.show');
Route::get('/monitor', [KingMonitorController::class, 'index'])->name('monitor.index');
