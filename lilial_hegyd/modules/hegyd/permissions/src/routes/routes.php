<?php

Route::group(['namespace' => 'Backend\ACL', 'prefix' => 'admin/permissions'], function ()
{
    get('/',
        [
            'uses' => 'PermissionsController@index',
            'as'   => 'permissions.index',
        ]
    );

    post('/',
        [
            'uses' => 'PermissionsController@update',
            'as'   => 'permissions.update',
        ]
    );
});