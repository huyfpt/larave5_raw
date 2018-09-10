<?php

namespace Hegyd\eCommerce\Providers;


use Hegyd\eCommerce\Events\Notifications\eCommerce\NewOrderEvent;
use Hegyd\eCommerce\Listeners\Notifications\eCommerce\NewOrderListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        NewOrderEvent::class => [NewOrderListener::class],
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