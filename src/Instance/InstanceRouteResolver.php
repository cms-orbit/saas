<?php

namespace Orbit\Saas\Instance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Orbit\Saas\Models\Instance;

class InstanceRouteResolver
{
    protected ?array $cache = null;

    /**
     * Resolve the instance from the request.
     */
    public function resolve(Request $request): ?Instance
    {
        $map = $this->getRouteMap();
        $host = $request->getHost();
        $path = trim($request->getPathInfo(), '/');

        // 1. Custom Domain / Subdomain Match
        if (isset($map['domains'][$host])) {
            return Instance::find($map['domains'][$host]);
        }

        // 2. Path Match (Simple first-segment check)
        $segments = explode('/', $path);
        $firstSegment = $segments[0] ?? '';

        if ($firstSegment && isset($map['paths'][$firstSegment])) {
            return Instance::find($map['paths'][$firstSegment]);
        }

        return null;
    }

    /**
     * Load the route map from cache.
     */
    protected function getRouteMap(): array
    {
        if ($this->cache !== null) {
            return $this->cache;
        }

        $cachePath = config('saas.route_cache_path');

        if (File::exists($cachePath)) {
            return $this->cache = require $cachePath;
        }

        return ['domains' => [], 'paths' => []];
    }
}
