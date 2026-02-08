<?php

namespace Orbit\Saas\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class ContainerMakeCommand extends Command
{
    protected $signature = 'saas:container make {name?}';
    protected $description = 'Create a new SaaS container';

    public function handle(): int
    {
        $name = $this->argument('name') ?? text('Container Name (e.g. Blog)');
        $slug = Str::slug($name);

        $strategy = select(
            'Isolation Strategy',
            ['multi_db' => 'Multi-Database', 'pg_rls' => 'PostgreSQL RLS', 'single' => 'Single Database'],
            'multi_db'
        );

        $path = config('saas.containers_path') . '/' . $slug;

        if (File::exists($path)) {
            $this->error("Container [{$slug}] already exists.");
            return 1;
        }

        $this->createStructure($path, $name, $slug, $strategy);

        $this->info("Container [{$name}] created at [{$path}].");

        return 0;
    }

    protected function createStructure(string $path, string $name, string $slug, string $strategy): void
    {
        $dirs = ['app/Providers', 'routes', 'config', 'resources', 'views', 'database', 'bootstrap'];

        foreach ($dirs as $dir) {
            File::makeDirectory($path . '/' . $dir, 0755, true);
        }

        // 1. Create container.json
        $config = [
            'name' => $name,
            'slug' => $slug,
            'isolation' => [
                'engine' => $strategy,
                'strategy' => $strategy === 'multi_db' ? 'multi_database' : 'single_database'
            ],
            'routing' => [
                'supports' => ['domain', 'subdomain', 'path']
            ],
            'providers' => [
                "Containers\\" . Str::studly($slug) . "\\App\\Providers\\ContainerServiceProvider"
            ]
        ];

        File::put($path . '/container.json', json_encode($config, JSON_PRETTY_PRINT));

        // 2. Create Placeholder ServiceProvider
        $namespace = "Containers\\" . Str::studly($slug) . "\\App\\Providers";

        $providerContent = "<?php\n\nnamespace {$namespace};\n\nuse Illuminate\Support\ServiceProvider;\n\nclass ContainerServiceProvider extends ServiceProvider\n{\n    public function register(): void { }\n    public function boot(): void { }\n}\n";

        File::put($path . '/app/Providers/ContainerServiceProvider.php', $providerContent);
    }
}
