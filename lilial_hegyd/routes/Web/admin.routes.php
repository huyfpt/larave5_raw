<?php

Route::group([
    'namespace'  => 'Admin',
    'prefix'     => 'admin',
    'as'         => 'admin.',
    'middleware' => ['auth'],
], function ()
{
    RoutesTools::includeRoutes('Web/Admin', true);
});