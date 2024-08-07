<?php

namespace ByCarmona141\KingMonitor\Tests;

use ByCarmona141\KingMonitor\KingMonitorServiceProvider;
use ByCarmona141\KingMonitor\Facades\KingMonitor;
use ByCarmona141\KingMonitor\RouteServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase {
    // Configuracion de bd
    protected function getEnvironmentSetUp($app) {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connection.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:'
        ]);
    }

    protected function getPackageProviders($app) {
        return [
            KingMonitorServiceProvider::class
        ];
    }

    protected function getPackageAliases($app) {
        return [
            'KingMonitor' => KingMonitor::class
        ];
    }
}