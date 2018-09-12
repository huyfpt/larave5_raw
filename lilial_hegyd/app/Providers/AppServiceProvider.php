<?php

namespace App\Providers;

use App\Http\ViewComposers\ExtranetComposer;
use App\Support\Form;
use App\Support\Html;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', ExtranetComposer::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (env('APP_ENV') !== 'local') {
            //$this->app['request']->server->set('HTTPS', true);
        } 

        //
        $this->app->singleton('html', function ($app) {
            return new Html($app['url'], $app['view']);
        });

        $this->app->singleton('form', function ($app) {
            $form = new Form($app['html'], $app['url'], $app['view'], $app['session.store']->token(), $app['request']);

            return $form->setSessionStore($app['session.store']);
        });

        $this->app->alias('html', Html::class);
        $this->app->alias('form', Form::class);

        Carbon::setLocale(config('app.locale'));
    }
}
