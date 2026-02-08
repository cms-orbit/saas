<?php

namespace Orbit\Saas;

use Illuminate\Support\ServiceProvider;
use Orbit\Saas\Console\Commands\ContainerMakeCommand;
use Orbit\Saas\Console\Commands\InstanceCreateCommand;
use Orbit\Saas\Console\Commands\InstanceDeleteCommand;
use Orbit\Saas\Console\Commands\RouteCacheCommand;

class SaasServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/saas.php',
            'saas'
        );

        $this->app->singleton(Theme\ThemeManager::class, function ($app) {
            return new Theme\ThemeManager();
        });

        $this->app->singleton(Container\ContainerManager::class, function ($app) {
            return new Container\ContainerManager($app);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/saas.php' => config_path('saas.php'),
            ], 'saas-config');

            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

            $this->commands([
                ContainerMakeCommand::class,
                InstanceCreateCommand::class,
                InstanceDeleteCommand::class,
                RouteCacheCommand::class,
            ]);
        }

        $this->app['router']->aliasMiddleware('saas', Http\Middleware\IdentifyInstance::class);
    }
}
