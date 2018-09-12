<?php

Route::group([
    'namespace'  => 'Frontend',
    'prefix'     => '/',
    'as'         => 'frontend.',
], function ()
{
    RoutesTools::includeRoutes('Web/Frontend', true);
});