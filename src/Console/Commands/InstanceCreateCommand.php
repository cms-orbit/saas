<?php

namespace Orbit\Saas\Console\Commands;

use Illuminate\Console\Command;
use Orbit\Saas\Models\Instance;
use Orbit\Saas\Models\RouteEndpoint;
use Illuminate\Support\Str;

use function Laravel\Prompts\text;
use function Laravel\Prompts\select;

class InstanceCreateCommand extends Command
{
    protected $signature = 'saas:instance create';
    protected $description = 'Create a new SaaS instance';

    public function handle(): int
    {
        $name = text('Instance Name (e.g. My Awesome Blog)');

        $containers = app(\Orbit\Saas\Container\ContainerManager::class)->all()->pluck('name', 'slug')->toArray();
        if (empty($containers)) {
            $this->error('No containers found. Create a container first.');
            return 1;
        }

        $containerSlug = select('Select Container', $containers);

        $instance = Instance::create([
            'name' => $name,
            'container_slug' => $containerSlug,
            'status' => 'active',
        ]);

        $type = select('Routing Strategy', ['domain' => 'Domain', 'subdomain' => 'Subdomain', 'path' => 'Path']);
        $value = text('Route Value (e.g. blog.com or myblog)');

        RouteEndpoint::create([
            'type' => $type,
            'value' => $value,
            'endpointable_type' => Instance::class,
            'endpointable_id' => $instance->id,
        ]);

        $this->info("Instance [{$name}] created successfully.");
        return 0;
    }
}
