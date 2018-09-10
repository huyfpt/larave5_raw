<?php namespace App\Providers;


use App\Events\Logs\Auth\LoginAsEvent;
use App\Events\Logs\Auth\LoginEvent;
use App\Events\Logs\Auth\LogoutAsEvent;
use App\Events\Logs\Auth\LogoutEvent;
use App\Events\Logs\CRUD\ActiveEvent;
use App\Events\Logs\CRUD\CreateEvent;
use App\Events\Logs\CRUD\DeleteEvent;
use App\Events\Logs\CRUD\ShowEvent;
use App\Events\Logs\CRUD\UpdateEvent;
use App\Events\Logs\Generic\GenericEvent;
use App\Events\Notifications\Content\NewsAvailableEvent;
use App\Listeners\Cache\CacheMissedListener;
use App\Listeners\Logs\Auth\LoginAsListener;
use App\Listeners\Logs\Auth\LoginListener;
use App\Listeners\Logs\Auth\LogoutAsListener;
use App\Listeners\Logs\Auth\LogoutListener;
use App\Listeners\Logs\CRUD\ActiveListener;
use App\Listeners\Logs\CRUD\CreateListener;
use App\Listeners\Logs\CRUD\DeleteListener;
use App\Listeners\Logs\CRUD\ShowListener;
use App\Listeners\Logs\CRUD\UpdateListener;
use App\Listeners\Logs\Generic\GenericEventListener;
use App\Listeners\Notifications\Content\NewsAvailableListener;
use Illuminate\Cache\Events\CacheMissed;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        // LOGS  ///////////////////////////////////////////////////////////////
        // CRUD
        CreateEvent::class                         => [CreateListener::class],
        UpdateEvent::class                         => [UpdateListener::class],
        DeleteEvent::class                         => [DeleteListener::class],
        ShowEvent::class                           => [ShowListener::class],
        ActiveEvent::class                         => [ActiveListener::class],

        // Auth
        LoginEvent::class                          => [LoginListener::class],
        LogoutEvent::class                         => [LogoutListener::class],
        LoginAsEvent::class                        => [LoginAsListener::class],
        LogoutAsEvent::class                       => [LogoutAsListener::class],

        // GenericEvent
        GenericEvent::class                       => [GenericEventListener::class],


        // NOTIFICATIONS ///////////////////////////////////////////////////////
        // Content
        NewsAvailableEvent::class                  => [NewsAvailableListener::class],

        // CACHE ///////////////////////////////////////////////////////////////
        CacheMissed::class                         => [CacheMissedListener::class],

    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     * @return void
     */
    public function boot()
    {
        parent::boot();

    }
}
