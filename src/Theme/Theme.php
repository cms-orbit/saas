<?php

namespace Orbit\Saas\Theme;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void register(string $container, string $name, string $provider)
 * @method static void boot(string $container, string $themeName)
 * 
 * @see \Orbit\Saas\Theme\ThemeManager
 */
class Theme extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ThemeManager::class;
    }
}
