<?php

Route::group(['as' => 'roles.', 'prefix' => 'roles', 'namespace' => 'ACL'], function ()
{
    Route::get('/search', [
        'as' => 'search',
        'uses' => 'RolesController@search',
    ]);
});