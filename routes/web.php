<?php

use Illuminate\Support\Facades\Route;
use ByCarmona141\KingMonitor\Http\Controllers\WEB\KingMonitorController;

Route::get('/monitor/{king_user_id}', [KingMonitorController::class, 'show'])->name('monitor.show');
Route::get('/monitor', [KingMonitorController::class, 'index'])->name('monitor.index');