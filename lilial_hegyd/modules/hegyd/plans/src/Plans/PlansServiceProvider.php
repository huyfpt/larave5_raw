<?php namespace Hegyd\Plans;

use Hegyd\Plans\Commands\ControllerCommand;
use Hegyd\Plans\Commands\MigrationCommand;
use Hegyd\Plans\Repositories\Contracts\PlansCategoryRepositoryInterface;
use Hegyd\Plans\Repositories\Contracts\PlansRepositoryInterface;
use Hegyd\Plans\Repositories\Eloquent\PlansCategoryRepository;
use Hegyd\Plans\Repositories\Eloquent\PlansRepository;
use Hegyd\Plans\Services\MacroServiceProvider;
use Hegyd\Uploads\UploadsServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class PlansServiceProvider extends ServiceProvider
{

    private $_root = __DIR__ . '/../';

    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom($this->_root . 'routes/routes.php');

        // Load migrations
        $this->loadMigrationsFrom($this->_root.'database/migrations');

        // Load translations
        $this->loadTranslationsFrom($this->_root . 'lang', 'hegyd-plans');

        // Load views
        $this->loadViewsFrom($this->_root . 'views/app', 'hegyd-plans');

        // Register commands
        $this->commands([
            'command.hegyd-plans.migration',
            'command.hegyd-plans.controller',
        ]);
    }


    public function register()
    {
        view()->addNamespace('hegyd-plans', $this->_root . 'views');

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
            $this->_root . 'config/config.php' => config_path('hegyd-plans.php'),
        ], 'hegyd_plans_config');

        $this->publishes([
            $this->_root . 'lang' => base_path('resources/lang/vendor/hegyd-plans'),
        ], 'hegyd_plans_lang');

        $this->publishes([
            $this->_root . 'routes/routes.php' => app_path('Http/Routes/hegyd-plans.routes.php'),
        ], 'hegyd_plans_routes');

        $this->publishes([
            $this->_root . 'views/app' => base_path('resources/views/vendor/hegyd-plans'),
        ], 'hegyd_plans_views');

        $this->publishes([
            $this->_root . 'assets' => public_path('vendor/hegyd/plans'),
        ], 'hegyd_plans_assets');


        $this->publishes([
            $this->_root . 'config/config.php' => config_path('hegyd-plans.php'),
            $this->_root . 'routes/routes.php' => base_path('routes/hegyd-plans.routes.php'),
        ], 'hegyd-plans');
    }

    /**
     * Register the artisan commands.
     *
     * @return void
     */
    private function _registerCommands()
    {
        $this->app->singleton('command.hegyd-plans.migration', function ($app)
        {
            return new MigrationCommand();
        });

        $this->app->singleton('command.hegyd-plans.controller', function ($app)
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
         * Bind repositories
         */
        $this->app->bind(PlansCategoryRepositoryInterface::class, PlansCategoryRepository::class);
        $this->app->bind(PlansRepositoryInterface::class, PlansRepository::class);

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
            $this->_root . 'config/config.php', 'hegyd-plans'
        );
    }
}