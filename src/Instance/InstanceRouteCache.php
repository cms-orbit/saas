<?php

namespace Orbit\Saas\Instance;

use Illuminate\Support\Facades\File;
use Orbit\Saas\Models\RouteEndpoint;

class InstanceRouteCache
{
    /**
     * Build and store the route map cache.
     */
    public function build(): void
    {
        $endpoints = RouteEndpoint::all();

        $map = [
            'domains' => $endpoints->whereIn('type', ['domain', 'subdomain'])->pluck('endpointable_id', 'value')->toArray(),
            'paths' => $endpoints->where('type', 'path')->pluck('endpointable_id', 'value')->toArray(),
        ];

        $content = '<?php return ' . var_export($map, true) . ';';

        File::put(config('saas.route_cache_path'), $content);
    }

    /**
     * Clear the route map cache.
     */
    public function clear(): void
    {
        File::delete(config('saas.route_cache_path'));
    }
}
