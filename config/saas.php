<?php

return [
    /**
     * SaaS Containers base directory.
     */
    'containers_path' => base_path('containers'),

    /**
     * SaaS Themes base directory.
     */
    'themes_path' => base_path('themes'),

    /**
     * Cache path for the instance route mapping.
     */
    'route_cache_path' => base_path('bootstrap/cache/instance_route_map.php'),

    /**
     * Default SaaS runtime engines.
     */
    'runtime_engines' => [
        'multi_db' => \Orbit\Saas\Runtime\Engines\MultiDatabaseEngine::class,
        'pg_rls' => \Orbit\Saas\Runtime\Engines\PostgreSqlRlsEngine::class,
        'single' => \Orbit\Saas\Runtime\Engines\SingleDatabaseEngine::class,
    ],
];
