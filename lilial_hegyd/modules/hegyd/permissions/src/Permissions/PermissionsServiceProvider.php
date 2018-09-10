<?php namespace Hegyd\Permissions;

use Hegyd\Permissions\Commands\AllCommand;
use Hegyd\Permissions\Commands\ControllerCommand;
use Hegyd\Permissions\Commands\MigrationCommand;
use Hegyd\Permissions\Commands\ModelCommand;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class PermissionsServiceProvider extends ServiceProvider
{

    private $_root = __DIR__ . '/../';

    public function boot()
    {
        // Publish config, routes, views
        $this->_publishFiles();

        // Load translations
        $this->loadTranslationsFrom($this->_root . 'lang', 'hegyd-permissions');

        // Load views
        $this->loadViewsFrom($this->_root . 'views/app', 'hegyd-permissions');

        // Register commands
        $this->commands([
            'command.hegyd-permissions.migration',
            'command.hegyd-permissions.controller',
        ]);
    }


    public function register()
    {
        view()->addNamespace('hegyd-permissions', $this->_root . 'views');

        $this->_registerCommands();

        $this->_registerDependencies();
    }

    /**
     * Publish files :
     * -> Config
     * -> Languages
     * -> Routes
     * -> Views
     * -> Assets
     */
    private function _publishFiles()
    {
        $this->publishes([
            $this->_root . 'config/config.php' => config_path('hegyd-permissions.php'),
        ], 'config');

        $this->publishes([
            $this->_root . 'lang' => base_path('resources/lang/vendor/hegyd-permissions'),
        ], 'lang');

        $this->publishes([
            $this->_root . 'routes/routes.php' => app_path('Http/Routes/hegyd-permissions.routes.php'),
        ], 'routes');

        $this->publishes([
            $this->_root . 'views/app' => base_path('resources/views/vendor/hegyd-permissions'),
        ], 'views');


        $this->publishes([
            $this->_root . 'config/config.php' => config_path('hegyd-permissions.php'),
            $this->_root . 'routes/routes.php' => app_path('Http/Routes/hegyd-permissions.routes.php'),
        ], 'hegyd-permissions');
    }

    /**
     * Register the artisan commands.
     *
     * @return void
     */
    private function _registerCommands()
    {
        $this->app->singleton('command.hegyd-permissions.migration', function ($app)
        {
            return new MigrationCommand();
        });

        $this->app->singleton('command.hegyd-permissions.controller', function ($app)
        {
            return new ControllerCommand();
        });
    }

    /**
     * Register all module dependencies
     */
    public function _registerDependencies()
    {
        /*
         * Register service provider for the dependency.
         */
        $this->app->register(\Collective\Html\HtmlServiceProvider::class);

        /*
         * Create aliases for the dependency.
         */
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Html', \Collective\Html\HtmlFacade::class);
        $loader->alias('Form', \Collective\Html\FormFacade::class);
    }
}