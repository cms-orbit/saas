<?php

namespace Orbit\Saas;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Orbit\Saas\Container\ContainerManager;
use Orbit\Saas\Instance\InstanceRouteResolver;
use Orbit\Saas\Runtime\RuntimeEngineInterface;

class ContainerBootloader
{
    public function __construct(
        protected Application $app,
        protected ContainerManager $containers,
        protected InstanceRouteResolver $resolver
    ) {
    }

    /**
     * Boot the SaaS environment from the request.
     */
    public function boot(Request $request): void
    {
        $instance = $this->resolver->resolve($request);

        if (!$instance) {
            return;
        }

        $container = $this->containers->get($instance->container_slug);

        if (!$container) {
            return;
        }

        // 1. Identify Runtime Engine for Isolation
        $engineClass = config("saas.runtime_engines.{$container['isolation']['engine']}");

        if ($engineClass && is_string($engineClass) && is_subclass_of($engineClass, RuntimeEngineInterface::class)) {
            /** @var RuntimeEngineInterface $engine */
            $engine = $this->app->make($engineClass);
            $engine->boot($container);
            $engine->bootInstance($instance);
        }

        // 2. Register Container Service Providers
        foreach ($container['providers'] ?? [] as $provider) {
            app()->register($provider);
        }

        // 3. Bind Instance Context
        app()->instance('saas.instance', $instance);
        app()->instance('saas.container', $container);

        // 4. Boot Theme
        if ($instance->theme) {
            app(Theme\ThemeManager::class)->boot($instance->container_slug, $instance->theme);
        }
    }
}
