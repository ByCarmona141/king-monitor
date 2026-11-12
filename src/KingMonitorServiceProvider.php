<?php

namespace ByCarmona141\KingMonitor;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Debug\ExceptionHandler;
use ByCarmona141\KingMonitor\Services\KingMonitorErrorService;
use ByCarmona141\KingMonitor\Console\Commands\KingMonitorCommand;

class KingMonitorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Binding requerido por la Facade KingMonitor
        $this->app->bind('king-monitor', fn () => new KingMonitor());

        $this->app->singleton(KingMonitorErrorService::class);

        $this->mergeConfigFrom($this->basePath('config/king-monitor.php'), 'king-monitor');
    }

    public function boot(): void
    {
        $this->loadRoutesFrom($this->basePath('routes/web.php'));
        $this->loadRoutesFrom($this->basePath('routes/api.php'));
        $this->loadViewsFrom($this->basePath('resources/views/'), 'king-monitor');
        $this->loadMigrationsFrom($this->basePath('database/migrations'));

        $this->commands([KingMonitorCommand::class]);

        $this->registerExceptionReporter();
        $this->registerPublishables();
    }

    private function registerExceptionReporter(): void
    {
        $this->app->afterResolving(
            ExceptionHandler::class,
            function (ExceptionHandler $handler, $app) {
                if ($app->bound('king.monitor.reporter.registered')) {
                    return;
                }

                $app->instance('king.monitor.reporter.registered', true);

                if (method_exists($handler, 'stopIgnoring')) {
                    $handler->stopIgnoring(AuthenticationException::class);
                }

                $handler->reportable(function (\Throwable $e) use ($app) {
                    rescue(
                        fn () => $app->make(KingMonitorErrorService::class)->handle($e),
                        report: false
                    );
                });

                $handler->renderable(function (\Exception $e) use ($app) {
                    rescue(
                        fn () => $app->make(KingMonitorErrorService::class)->handle($e),
                        report: false
                    );
                });
            }
        );
    }

    private function registerPublishables(): void
    {
        $this->publishes(
            [$this->basePath('routes/web.php') => base_path('routes/king-monitor.php')],
            'king-monitor-routes'
        );
        $this->publishes(
            [$this->basePath('resources/views/') => resource_path('views/vendor/king-monitor')],
            'king-monitor-views'
        );
        $this->publishes(
            [$this->basePath('config/king-monitor.php') => config_path('king-monitor.php')],
            'king-monitor-config'
        );
    }

    protected function basePath(string $path = ''): string
    {
        return __DIR__ . '/../' . $path;
    }
}