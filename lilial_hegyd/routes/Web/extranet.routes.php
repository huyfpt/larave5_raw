<?php

Route::group([
    'namespace'  => 'Extranet',
    'middleware' => ['auth'],
], function ()
{
    Route::get('/admin', [
        'as'   => 'index',
        'uses' => 'IndexController@index',
    ]);

    Route::group(['as' => 'extranet.'], function ()
    {
        RoutesTools::includeRoutes('Web/Extranet', true);
    });
});
