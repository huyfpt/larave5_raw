<?php

Route::group([
    'namespace'  => 'Frontend',
    'prefix'     => 'frontend',
    'as'         => '/',
], function ()
{
    RoutesTools::includeRoutes('Web/Front', true);
});