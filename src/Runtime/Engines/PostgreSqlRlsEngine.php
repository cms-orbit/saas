<?php

namespace Orbit\Saas\Runtime\Engines;

use Orbit\Saas\Models\Instance;
use Orbit\Saas\Runtime\RuntimeEngineInterface;

class PostgreSqlRlsEngine implements RuntimeEngineInterface
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
        // PostgreSQL RLS switch
    }
}
