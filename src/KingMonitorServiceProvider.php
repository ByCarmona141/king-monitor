<?php

namespace ByCarmona141\KingMonitor;

use Illuminate\Support\ServiceProvider;

use ByCarmona141\KingMonitor\Console\Commands\KingMonitorCommand;

class KingMonitorServiceProvider extends ServiceProvider {
    public function register() {
        $this->app->bind('king-monitor', function() {
            return new KingMonitor;
        });

        // Carga de configuracion
        $this->mergeConfigFrom($this->basePath('config/king-monitor.php'), 'king-monitor');
    }

    public function boot() {
        // Registro de rutas
        $this->loadRoutesFrom($this->basePath('routes/web.php'));
        $this->loadRoutesFrom($this->basePath('routes/api.php'));

        // Registro de vistas
        $this->loadViewsFrom(
            $this->basePath('resources/views/'),
            'king-monitor'
        );

        // Registro de migraciones
        $this->loadMigrationsFrom(
            $this->basePath('database/migrations')
        );

        // Registro de comandos
        $this->commands([
            KingMonitorCommand::class
        ]);

        // Publicar rutas
        $this->publishes(
            [$this->basePath('routes/web.php') => base_path('routes/king-monitor.php')],
            'king-monitor-routes'
        );

        // Publicar vistas
        $this->publishes(
            [$this->basePath('resources/views/') => resource_path('views/vendor/king-monitor')],
            'king-monitor-views'
        );

        // Publicar configuracion
        $this->publishes(
            [$this->basePath('config/king-monitor.php') => config_path('king-monitor.php')],
            'king-monitor-config'
        );
    }

    protected function basePath($path = '') {
        return __DIR__ . '/../' . $path;
    }
}