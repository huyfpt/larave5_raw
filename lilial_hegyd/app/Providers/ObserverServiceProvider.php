<?php namespace App\Providers;


use App\Models\Common\Shop;
use App\Models\Common\User;
use App\Observers\BaseObserver;
use Hegyd\News\Models\News;
use Hegyd\News\Models\NewsCategory;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{

    protected $observable = [
        // Common
        User::class,
        Shop::class,

        // Content
        News::class,
        NewsCategory::class,
    ];

    protected $observers = [
    ];

    public function boot()
    {
        foreach ($this->observable as $class)
        {

            if (isset($this->observers[$class]))
            {
                $class_observer = $this->observers[$class];
            } else
            {
                $class_observer = $class . 'Observer';

                // $class est livrée avec le namespace App\Models
                // On remplace donc Models par Observers pour obtenir le bon namespace
                $class_observer = preg_replace('#Models#', 'Observers', $class_observer);
            }

            // Si la classe {Model}Observer existe on observe à partir de celle là
            if (class_exists($class_observer))
            {
                $class::observe(new $class_observer); // On informe que $class est maintenant à l'application par l'instance de {Model}Observer
            } // Sinon on prend l'observeur de base
            else
            {
                $class::observe(new BaseObserver());
            }
        }
    }

    public function register()
    {
    }

}