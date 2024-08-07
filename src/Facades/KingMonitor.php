<?php

namespace ByCarmona141\KingMonitor\Facades;

use Illuminate\Support\Facades\Facade;

class KingMonitor extends Facade {
    protected static function getFacadeAccessor() {
        return 'king-monitor';
    }
}