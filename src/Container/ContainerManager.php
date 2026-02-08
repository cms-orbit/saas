<?php

namespace Orbit\Saas\Container;

use Illuminate\Container\Container as LaravelContainer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class ContainerManager
{
    protected array $registered = [];

    public function __construct(protected LaravelContainer $app)
    {
    }

    /**
     * Register a container manually (usually from an external package).
     */
    public function register(array $config): void
    {
        $this->registered[$config['slug']] = $config;
    }

    /**
     * Get all registered containers (merging filesystem and manual registration).
     */
    public function all(): Collection
    {
        $path = config('saas.containers_path');

        $filesystemContainers = collect();

        if (File::isDirectory($path)) {
            $filesystemContainers = collect(File::directories($path))
                ->map(function ($directory) {
                    $jsonPath = $directory . '/container.json';
                    if (File::exists($jsonPath)) {
                        return json_decode(File::get($jsonPath), true);
                    }
                    return null;
                })
                ->filter()
                ->keyBy('slug');
        }

        return $filesystemContainers->merge($this->registered);
    }

    /**
     * Get a specific container by slug.
     */
    public function get(string $slug): ?array
    {
        return $this->all()->get($slug);
    }
}
