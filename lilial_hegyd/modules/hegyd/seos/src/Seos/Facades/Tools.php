<?php

namespace Hegyd\Seos\Facades;

use Illuminate\Support\Facades\Facade;

class Tools extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \App\Support\AppTools::class;
    }

}
