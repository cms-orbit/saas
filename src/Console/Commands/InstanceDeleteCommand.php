<?php

namespace Orbit\Saas\Console\Commands;

use Illuminate\Console\Command;
use Orbit\Saas\Models\Instance;
use Orbit\Saas\Instance\InstanceRouteCache;

use function Laravel\Prompts\select;

class InstanceDeleteCommand extends Command
{
    protected $signature = 'saas:instance delete';
    protected $description = 'Delete a SaaS instance';

    public function handle(InstanceRouteCache $cache): int
    {
        $instances = Instance::all()->pluck('name', 'id')->toArray();

        if (empty($instances)) {
            $this->error('No instances found.');
            return 1;
        }

        $id = select('Select Instance to delete', $instances);

        $instance = Instance::find($id);

        if ($this->confirm("Are you sure you want to delete instance [{$instance->name}]?")) {
            $instance->routes()->delete();
            $instance->delete();
            $cache->build();
            $this->info('Instance deleted and cache rebuilt.');
        }

        return 0;
    }
}
