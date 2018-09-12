<?php

namespace App\Console;

use App\Console\Commands\NotifyGedEvent;
use App\Console\Commands\UpdateAddressGpsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CreateSiteMap::class,
        Commands\Imports::class,
        //Commands\Download::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        /* Mise à jour des coordonées GPS de toutes les adresses de la plateforme chaque nuit (0h00)*/
        $schedule->command('address:update-gps')->daily();

        /* Notifications avec le nombre de nouveaux documents disponible depuis la veille */
        $schedule->command('notify:new-uploads')->at('06:00');

        /* Alerte seuil stock */
        $schedule->command('hegyd:ecommerce-product-stock-alert')->daily();

        /* Suppression des paniers */
        $schedule->command('hegyd:ecommerce-clear-cart')->everyThirtyMinutes();

        /* Lancement des jobs présent dans la base de données */
        $schedule->command('queue:work --tries=3 --sleep=5')->everyMinute()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
//        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}