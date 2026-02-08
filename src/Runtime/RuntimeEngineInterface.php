<?php

namespace Orbit\Saas\Runtime;

use Orbit\Saas\Models\Instance;

interface RuntimeEngineInterface
{
    /**
     * Boot the isolation engine for a specific container.
     */
    public function boot(array $container): void;

    /**
     * Boot the isolation engine for a specific instance.
     */
    public function bootInstance(Instance $instance): void;

    /**
     * Switch the isolation context (e.g. database connection) to the instance.
     */
    public function switchContext(Instance $instance): void;
}
