<?php

namespace Orbit\Saas\Facades;

use Illuminate\Support\Facades\Facade;
use Orbit\Saas\Container\ContainerManager;

/**
 * @method static void registerContainer(array $config)
 * @method static \Illuminate\Support\Collection getContainers()
 * @method static array|null getContainer(string $slug)
 * 
 * @see \Orbit\Saas\Container\ContainerManager
 */
class Saas extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ContainerManager::class;
    }

    /**
     * Proxy for register.
     */
    public static function registerContainer(array $config): void
    {
        static::getFacadeRoot()->register($config);
    }

    /**
     * Proxy for all.
     */
    public static function getContainers(): \Illuminate\Support\Collection
    {
        return static::getFacadeRoot()->all();
    }

    /**
     * Proxy for get.
     */
    public static function getContainer(string $slug): ?array
    {
        return static::getFacadeRoot()->get($slug);
    }
}
