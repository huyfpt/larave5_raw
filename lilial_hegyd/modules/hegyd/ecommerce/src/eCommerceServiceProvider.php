<?php namespace Hegyd\eCommerce;

use Hegyd\eCommerce\Console\Commands\ClearCartCommand;
use Hegyd\eCommerce\Console\Commands\ProductStockAlertCommand;
use Hegyd\eCommerce\Providers\EventServiceProvider;
use Hegyd\eCommerce\Providers\ObserverServiceProvider;
use Hegyd\eCommerce\Providers\RepositoryServiceProvider;
use Hegyd\eCommerce\Services\Common\MacroServiceProvider;
use Hegyd\eCommerce\Http\ViewComposers\CartComposer;
use Hegyd\Uploads\UploadsServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

use Hegyd\eCommerce\Repositories\Contracts\ProductCatalog\BrandRepositoryInterface;
use Hegyd\eCommerce\Repositories\Contracts\ProductCatalog\AttributeRepositoryInterface;
use Hegyd\eCommerce\Repositories\Contracts\ProductCatalog\FeatureRepositoryInterface;
use Hegyd\eCommerce\Repositories\Eloquent\ProductCatalog\BrandRepository;
use Hegyd\eCommerce\Repositories\Eloquent\ProductCatalog\AttributeRepository;
use Hegyd\eCommerce\Repositories\Eloquent\ProductCatalog\FeatureRepository;

class eCommerceServiceProvider extends ServiceProvider
{


    private $_root = __DIR__ . '/../';

    public function boot()
    {
        Schema::defaultStringLength(191);

        $this->loadRoutesFrom($this->_root . 'routes/web.php');
        $this->loadMigrationsFrom($this->_root . 'database/migrations');
        $this->loadTranslationsFrom($this->_root . 'resources/lang', 'hegyd-ecommerce');
        $this->loadViewsFrom($this->_root . 'resources/views', 'hegyd-ecommerce');

        // Register commands
/*        $this->commands([
            'command.hegyd-ecommerce.product-stock-alert',
            'command.hegyd-ecommerce.clear-cart',
        ]);*/

        //view()->composer('*', CartComposer::class);
    }


    public function register()
    {

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
     * -> Migrations
     * -> Routes
     * -> Views
     * -> Assets
     */
    private function _registerPublishable()
    {
        $publishable = [
            'hegyd_ecommerce_assets'     => [
                "{$this->_root}/resources/assets/" => public_path('vendor/hegyd/ecommerce'),
            ],
            'hegyd_ecommerce_migrations' => [
                "{$this->_root}/database/migrations" => database_path('migrations'),
            ],
            'hegyd_ecommerce_config'     => [
                "{$this->_root}/config/hegyd-ecommerce.php" => config_path('hegyd-ecommerce.php'),
            ],
            'hegyd_ecommerce_lang'       => [
                "{$this->_root}/resources/lang/" => base_path('resources/lang/vendor/hegyd/ecommerce'),
            ],
            'hegyd_ecommerce_routes'     => [
                "{$this->_root}/routes/web.php" => base_path('routes/hegyd-ecommerce.routes.php'),
            ],
            'hegyd_ecommerce_views'      => [
                "{$this->_root}/resources/views/" => resource_path('views/vendor/hegyd-ecommerce'),
            ],
        ];

        foreach ($publishable as $group => $paths)
        {
            $this->publishes($paths, $group);
        }
    }

    /**
     * Register the artisan commands.
     *
     * @return void
     */
    private function _registerCommands()
    {
        $this->app->singleton('command.hegyd-ecommerce.product-stock-alert', function ($app) {
            return new ProductStockAlertCommand();
        });

        $this->app->singleton('command.hegyd-ecommerce.clear-cart', function ($app) {
            return new ClearCartCommand();
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
        $this->app->bind(AttributeRepositoryInterface::class, AttributeRepository::class);
        $this->app->bind(FeatureRepositoryInterface::class, FeatureRepository::class);
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);

        /*
         * Register service provider for the dependency.
         */
        $this->app->register(UploadsServiceProvider::class);
        $this->app->register(MacroServiceProvider::class);
        $this->app->register(\Collective\Html\HtmlServiceProvider::class);
        $this->app->register(\Barryvdh\DomPDF\ServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(ObserverServiceProvider::class);

        /*
         * Create aliases for the dependency.
         */
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Html', \Collective\Html\HtmlFacade::class);
        $loader->alias('Form', \Collective\Html\FormFacade::class);
        $loader->alias('PDF', \Barryvdh\DomPDF\Facade::class);
    }


    private function _registerConfig()
    {
        $this->mergeConfigFrom(
            $this->_root . 'config/hegyd-ecommerce.php', 'hegyd-ecommerce'
        );
    }
}