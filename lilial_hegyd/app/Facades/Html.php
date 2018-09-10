<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Html extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return \App\Support\Html::class;
//        return 'html';
    }

}