<?php

namespace KUIFortify\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $signature = 'kui-fortify:install {stack=blade : The development stack that should be replaced (blade,vue,vue-jsx,react)}
                        {--composer=global : Absolute path to the Composer binary which should be used to install packages}';

    /**
     * The console command description.
     *
     * @var string
     */
    public $description = 'Setup routes, service providers and views';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->writeLogo();

        $this->replaceFavIcon();

        $this->callSilent('vendor:publish', ['--provider' => 'Laravel\Fortify\FortifyServiceProvider']);

        if ($this->argument('stack') === 'blade') {
            return $this->installBlade();
        }

        if ($this->argument('stack') === 'vue') {
            return $this->installVue('sfc');
        }

        if ($this->argument('stack') === 'vue-jsx') {
            return $this->installVue('jsx');
        }

        if ($this->argument('stack') === 'react') {
            return $this->installReact();
        }
    }

    /**
     * Install blade stack.
     *
     * @return void
     */
    protected function installBlade()
    {
        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
            return [
                '@alpinejs/collapse' => '^3.9.1',
                '@tailwindcss/forms' => '^0.5.0',
                'alpinejs' => '^3.9.1',
                'autoprefixer' => '^10.4.2',
                'postcss' => '^8.4.7',
                'postcss-import' => '^14.0.2',
                'tailwindcss' => '^3.0.23',
                'perfect-scrollbar' => '^1.5.5',
                'egalink-toasty.js' => '^1.5.5'
            ] + $packages;
        });

        // Views...
        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/components'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/profile'));

        (new Filesystem)->ensureDirectoryExists(app_path('View/Components'));

        // Clean directories
        (new Filesystem)->cleanDirectory(resource_path('views/auth'));
        (new Filesystem)->cleanDirectory(resource_path('views/layouts'));
        (new Filesystem)->cleanDirectory(resource_path('views/components'));
        (new Filesystem)->cleanDirectory(resource_path('views/profile'));

        (new Filesystem)->cleanDirectory(app_path('View/Components'));

        // Copy views
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/blade/resources/views/auth', resource_path('views/auth'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/blade/resources/views/layouts', resource_path('views/layouts'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/blade/resources/views/components', resource_path('views/components'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/blade/resources/views/profile', resource_path('views/profile'));

        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/blade/app/View/Components', app_path('View/Components'));

        // Home
        copy(__DIR__ . '/../../stubs/blade/resources/views/dashboard.blade.php', resource_path('views/dashboard.blade.php'));

        // Routes
        copy(__DIR__ . '/../../stubs/blade/routes/web.php', base_path('routes/web.php'));

        // Assets
        copy(__DIR__ . '/../../stubs/blade/resources/css/app.css', resource_path('css/app.css'));
        copy(__DIR__ . '/../../stubs/blade/resources/js/app.js', resource_path('js/app.js'));
        copy(__DIR__ . '/../../stubs/blade/tailwind.config.js', base_path('tailwind.config.js'));
        copy(__DIR__ . '/../../stubs/blade/webpack.mix.js', base_path('webpack.mix.js'));

        // Service provider
        copy(__DIR__ . '/../../stubs/blade/app/Providers/KUIFortifyServiceProvider.php', app_path('Providers/KUIFortifyServiceProvider.php'));

        // User model
        copy(__DIR__ . '/../../stubs/blade/app/Models/User.php', app_path('Models/User.php'));

        $this->replaceInFile('/home', '/dashboard', app_path('Providers/RouteServiceProvider.php'));

        $this->replaceInFile('/home', '/dashboard', resource_path('views/welcome.blade.php'));

        $this->replaceInFile('Home', '{{ __("Dashboard") }}', resource_path('views/welcome.blade.php'));

        $this->replaceInFile(
            'App\Providers\RouteServiceProvider::class,',
            "App\Providers\RouteServiceProvider::class,\n\t\tApp\Providers\FortifyServiceProvider::class,\n\t\tApp\Providers\KUIFortifyServiceProvider::class,",
            config_path('app.php')
        );

        // Icons
        $this->requireComposerPackages('blade-ui-kit/blade-heroicons:^1.3');

        $this->line('');
        $this->info('K UI scaffolding installed successfully.');
        $this->comment('Please execute the "npm install && npm run dev" command to build your assets.');

        return 0;
    }

    /**
     * Install inertia vue stack.
     *
     * @param string $type
     * @return void
     */
    protected function installVue($type)
    {
        $this->error('Inertia vue stack will be available soon.');
        return 0;
    }

    /**
     * Install inertia react stack.
     *
     * @return void
     */
    protected function installReact()
    {
        $this->error('Inertia react stack will be available soon.');
        return 0;
    }

    protected function replaceFavIcon()
    {
        (new Filesystem)->ensureDirectoryExists(base_path('public'));
        copy(__DIR__ . '/../../stubs/favicon.ico', base_path('public/favicon.ico'));
    }

    /**
     * Copied from https://github.com/laravel/breeze/blob/1.x/src/Console/InstallCommand.php
     * Installs the given Composer Packages into the application.
     *
     * @param  mixed  $packages
     * @return void
     */
    protected function requireComposerPackages($packages)
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = ['php', $composer, 'require'];
        }

        $command = array_merge(
            $command ?? ['composer', 'require'],
            is_array($packages) ? $packages : func_get_args()
        );

        (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
    }

    /**
     * Copied from https://github.com/laravel/breeze/blob/1.x/src/Console/InstallCommand.php
     * Update the "package.json" file.
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (!file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }

    /**
     * Copied from https://github.com/laravel/breeze/blob/1.x/src/Console/InstallCommand.php
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    protected function writeLogo()
    {
        $logo = PHP_EOL . '<fg=bright-blue>
██╗  ██╗     ██╗   ██╗██╗
██║ ██╔╝     ██║   ██║██║
█████╔╝█████╗██║   ██║██║
██╔═██╗╚════╝██║   ██║██║
██║  ██╗     ╚██████╔╝██║
╚═╝  ╚═╝      ╚═════╝ ╚═╝
        </>' . PHP_EOL;

        return $this->line($logo);
    }
}