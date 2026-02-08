<?php

namespace Orbit\Saas\Console\Commands;

use Illuminate\Console\Command;
use Orbit\Saas\Instance\InstanceRouteCache;

class RouteCacheCommand extends Command
{
    protected $signature = 'saas:route-cache {action=build}';
    protected $description = 'Build or clear the SaaS instance route cache';

    public function handle(InstanceRouteCache $cache): int
    {
        $action = $this->argument('action');

        if ($action === 'build') {
            $cache->build();
            $this->info('SaaS route cache built.');
        } else {
            $cache->clear();
            $this->info('SaaS route cache cleared.');
        }

        return 0;
    }
}
