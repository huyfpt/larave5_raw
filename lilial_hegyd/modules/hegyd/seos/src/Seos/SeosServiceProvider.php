<?php namespace Hegyd\Seos;

use Hegyd\Seos\Commands\MigrationCommand;
use Hegyd\Seos\Repositories\Contracts\SeosRepositoryInterface;
use Hegyd\Seos\Repositories\Eloquent\SeosRepository;
use Hegyd\Seos\Repositories\Contracts\SeoUrlRedirectsRepositoryInterface;
use Hegyd\Seos\Repositories\Eloquent\SeoUrlRedirectsRepository;
use Hegyd\Seos\Services\MacroServiceProvider;
use Hegyd\Uploads\UploadsServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class SeosServiceProvider extends ServiceProvider
{

    private $_root = __DIR__ . '/../';

    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom($this->_root . 'routes/routes.php');
        
        // Load migrations
        $this->loadMigrationsFrom($this->_root.'database/migrations');

        // Load translations
        $this->loadTranslationsFrom($this->_root . 'lang', 'hegyd-seos');

        // Load views
        $this->loadViewsFrom($this->_root . 'views/app', 'hegyd-seos');

        // Register commands
        $this->commands([
            'command.hegyd-seos.migration',
        ]);
    }


    public function register()
    {
        view()->addNamespace('hegyd-seos', $this->_root . 'views');

        $this->_registerConfig();
        $this->_registerDependencies();

        if ($this->app->runningInConsole())
        {
            $this->_registerCommands();
            $this->_registerPublishable();
        }

    }

    /**
     * Publish files :
     * -> Config
     * -> Languages
     * -> Routes
     * -> Views
     * -> Assets
     */
    private function _registerPublishable()
    {
        $this->publishes([
            $this->_root . 'config/config.php' => config_path('hegyd-seos.php'),
        ], 'hegyd_seos_config');

        $this->publishes([
            $this->_root . 'lang' => base_path('resources/lang/vendor/hegyd-seos'),
        ], 'hegyd_seos_lang');

        $this->publishes([
            $this->_root . 'routes/routes.php' => app_path('Http/Routes/hegyd-seos.routes.php'),
        ], 'hegyd_seos_routes');

        $this->publishes([
            $this->_root . 'views/app' => base_path('resources/views/vendor/hegyd-seos'),
        ], 'hegyd_seos_views');

        $this->publishes([
            $this->_root . 'assets' => public_path('vendor/hegyd/seos'),
        ], 'hegyd_seos_assets');


        $this->publishes([
            $this->_root . 'config/config.php' => config_path('hegyd-seos.php'),
            $this->_root . 'routes/routes.php' => base_path('routes/hegyd-seos.routes.php'),
        ], 'hegyd-seos');
    }

    /**
     * Register the artisan commands.
     *
     * @return void
     */
    private function _registerCommands()
    {
        $this->app->singleton('command.hegyd-seos.migration', function ($app)
        {
            return new MigrationCommand();
        });
    }

    /**
     * Register all module dependencies
     */
    public function _registerDependencies()
    {
        /*
         * Bind repositories
         */
        $this->app->bind(SeoUrlRedirectsRepositoryInterface::class, SeoUrlRedirectsRepository::class);
        $this->app->bind(SeosRepositoryInterface::class, SeosRepository::class);

        /*
         * Register service provider for the dependency.
         */
        $this->app->register(UploadsServiceProvider::class);
        $this->app->register(MacroServiceProvider::class);
        $this->app->register(\Collective\Html\HtmlServiceProvider::class);

        /*
         * Create aliases for the dependency.
         */
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Html', \Collective\Html\HtmlFacade::class);
        $loader->alias('Form', \Collective\Html\FormFacade::class);
    }


    private function _registerConfig()
    {
        $this->mergeConfigFrom(
            $this->_root . 'config/config.php', 'hegyd-seos'
        );
    }
}