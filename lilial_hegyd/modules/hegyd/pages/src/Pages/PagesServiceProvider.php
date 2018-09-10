<?php namespace Hegyd\Pages;

use Hegyd\Pages\Commands\MigrationCommand;
use Hegyd\Pages\Repositories\Contracts\PagesRepositoryInterface;
use Hegyd\Pages\Repositories\Eloquent\PagesRepository;
use Hegyd\Pages\Services\MacroServiceProvider;
use Hegyd\Uploads\UploadsServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class PagesServiceProvider extends ServiceProvider
{

    private $_root = __DIR__ . '/../';

    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom($this->_root . 'routes/route.php');
        // Load migrations
        $this->loadMigrationsFrom($this->_root.'database/migrations');

        // Load translations
        $this->loadTranslationsFrom($this->_root . 'lang', 'hegyd-pages');

        // Load views
        $this->loadViewsFrom($this->_root . 'views/app', 'hegyd-pages');

        // Register commands
        $this->commands([
            'command.hegyd-pages.migration',
        ]);
    }


    public function register()
    {
        view()->addNamespace('hegyd-pages', $this->_root . 'views');

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
            $this->_root . 'config/config.php' => config_path('hegyd-pages.php'),
        ], 'hegyd_pages_config');

        $this->publishes([
            $this->_root . 'lang' => base_path('resources/lang/vendor/hegyd-pages'),
        ], 'hegyd_pages_lang');

        $this->publishes([
            $this->_root . 'routes/routes.php' => app_path('Http/Routes/hegyd-pages.routes.php'),
        ], 'hegyd_pages_routes');

        $this->publishes([
            $this->_root . 'views/app' => base_path('resources/views/vendor/hegyd-pages'),
        ], 'hegyd_pages_views');

        $this->publishes([
            $this->_root . 'assets' => public_path('vendor/hegyd/pages'),
        ], 'hegyd_pages_assets');


        $this->publishes([
            $this->_root . 'config/config.php' => config_path('hegyd-pages.php'),
            $this->_root . 'routes/routes.php' => base_path('routes/hegyd-pages.routes.php'),
        ], 'hegyd-pages');
    }

    /**
     * Register the artisan commands.
     *
     * @return void
     */
    private function _registerCommands()
    {
        $this->app->singleton('command.hegyd-pages.migration', function ($app)
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
        $this->app->bind(PagesRepositoryInterface::class, PagesRepository::class);

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
            $this->_root . 'config/config.php', 'hegyd-pages'
        );
    }
}