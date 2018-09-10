<?php
namespace Hegyd\Faqs;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;
use Hegyd\Faqs\Commands\ControllerCommand;
use Hegyd\Faqs\Commands\MigrationCommand;
use Hegyd\Faqs\Repositories\Contracts\NewsletterRepositoryInterface;
use Hegyd\Faqs\Repositories\Contracts\FaqsCategoryRepositoryInterface;
use Hegyd\Faqs\Repositories\Contracts\FaqsRepositoryInterface;
use Hegyd\Faqs\Repositories\Eloquent\FaqsCategoryRepository;
use Hegyd\Faqs\Repositories\Eloquent\NewslettersRepository;
use Hegyd\Faqs\Repositories\Eloquent\FaqsRepository;
use Hegyd\Faqs\Services\MacroServiceProvider;
use Hegyd\Faqs\Services\ValidationServiceProvider;
use Hegyd\Uploads\UploadsServiceProvider;

class FaqsServiceProvider extends ServiceProvider
{

    private $_root = __DIR__ . '/../';

    public function boot()
    {
        // Load translations
        $this->loadTranslationsFrom($this->_root . 'lang', 'hegyd-faqs');

        // Load views
        $this->loadViewsFrom($this->_root . 'views/app', 'hegyd-faqs');

        // Register commands
        $this->commands([
            'command.hegyd-faqs.migration',
            'command.hegyd-faqs.controller',
        ]);
    }


    public function register()
    {
        view()->addNamespace('hegyd-faqs', $this->_root . 'views');

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
            $this->_root . 'config/config.php' => config_path('hegyd-faqs.php'),
        ], 'hegyd_faqs_config');

        $this->publishes([
            $this->_root . 'lang' => base_path('resources/lang/vendor/hegyd-faqs'),
        ], 'hegyd_faqs_lang');

        $this->publishes([
            $this->_root . 'routes/routes.php' => app_path('Http/Routes/hegyd-faqs.routes.php'),
        ], 'hegyd_faqs_routes');

        $this->publishes([
            $this->_root . 'views/app' => base_path('resources/views/vendor/hegyd-faqs'),
        ], 'hegyd_faqs_views');

        $this->publishes([
            $this->_root . 'assets' => public_path('vendor/hegyd/faqs'),
        ], 'hegyd_faqs_assets');


        $this->publishes([
            $this->_root . 'config/config.php' => config_path('hegyd-faqs.php'),
            $this->_root . 'routes/routes.php' => base_path('routes/hegyd-faqs.routes.php'),
        ], 'hegyd-faqs');
    }

    /**
     * Register the artisan commands.
     *
     * @return void
     */
    private function _registerCommands()
    {
        $this->app->singleton('command.hegyd-faqs.migration', function ($app)
        {
            return new MigrationCommand();
        });

        $this->app->singleton('command.hegyd-faqs.controller', function ($app)
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
        $this->app->bind(FaqsCategoryRepositoryInterface::class, FaqsCategoryRepository::class);
        $this->app->bind(FaqsRepositoryInterface::class, FaqsRepository::class);
        $this->app->bind(NewsletterRepositoryInterface::class, NewslettersRepository::class);

        /*
         * Register service provider for the dependency.
         */
        $this->app->register(UploadsServiceProvider::class);
        $this->app->register(MacroServiceProvider::class);
        $this->app->register(ValidationServiceProvider::class);
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
            $this->_root . 'config/config.php', 'hegyd-faqs'
        );
    }
}