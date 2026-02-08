<?php

namespace Orbit\Saas\Theme;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;

class ThemeManager
{
    protected array $themes = [];

    /**
     * Register a new theme.
     */
    public function register(string $container, string $name, string $provider): void
    {
        $this->themes[$container][$name] = $provider;
    }

    /**
     * Boot the theme for the given instance.
     */
    public function boot(string $container, string $themeName): void
    {
        $provider = $this->themes[$container][$themeName] ?? null;

        if (!$provider) {
            return;
        }

        // 1. Register the theme service provider
        app()->register($provider);

        // 2. Override View Paths (Placeholder for logic)
        // Usually themes will register their own namespaces, 
        // but we might want to override the 'container' namespace.

        // 3. Vite Manifest Switching
        // Vite::useManifest($manifestPath);
    }
}
