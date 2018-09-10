<?php

Route::group(['namespace' => 'ACL', 'prefix' => 'permissions'], function ()
{
    Route::get('/',
        [
            'uses' => 'PermissionsController@index',
            'as'   => 'permissions.index',
        ]
    );

    Route::put('/',
        [
            'uses' => 'PermissionsController@update',
            'as'   => 'permissions.update',
        ]
    );
});