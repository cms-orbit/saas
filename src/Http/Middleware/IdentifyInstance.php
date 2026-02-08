<?php

namespace Orbit\Saas\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Orbit\Saas\ContainerBootloader;

class IdentifyInstance
{
    public function __construct(protected ContainerBootloader $bootloader)
    {
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $this->bootloader->boot($request);

        return $next($request);
    }
}
