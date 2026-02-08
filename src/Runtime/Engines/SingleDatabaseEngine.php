<?php

namespace Orbit\Saas\Runtime\Engines;

use Orbit\Saas\Models\Instance;
use Orbit\Saas\Runtime\RuntimeEngineInterface;

class SingleDatabaseEngine implements RuntimeEngineInterface
{
    public function boot(array $container): void
    {
    }

    public function bootInstance(Instance $instance): void
    {
        $this->switchContext($instance);
    }

    public function switchContext(Instance $instance): void
    {
        // Single DB isolation using Global Scopes
    }
}
