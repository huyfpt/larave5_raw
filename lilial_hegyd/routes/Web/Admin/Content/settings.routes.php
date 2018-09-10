<?php
Route::group(['namespace' => 'Content', 'prefix' => 'parametres'],
    function ()
    {
        Route::get('/', [
            'as'   => 'settings.index',
            'uses' => 'SettingsController@index',
        ]);

        Route::put('/', [
            'as'   => 'settings.update',
            'uses' => 'SettingsController@update',
        ]);
    });