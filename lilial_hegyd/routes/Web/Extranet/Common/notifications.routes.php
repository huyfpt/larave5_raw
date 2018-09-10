<?php

Route::group(['namespace' => 'Common', 'prefix' => 'notifications', 'as' => 'notifications.'], function ()
{
    Route::get('/', [
        'as'   => 'index',
        'uses' => 'NotificationsController@index',
    ]);

    Route::get('/counter', [
        'as'   => 'counter',
        'uses' => 'NotificationsController@counter',
    ]);

    Route::put('/{id}/read', [
        'as'   => 'read',
        'uses' => 'NotificationsController@read',
    ]);

    Route::put('/read-all', [
        'as'   => 'read-all',
        'uses' => 'NotificationsController@readAll',
    ]);

    Route::put('/{id}/unread', [
        'as'   => 'unread',
        'uses' => 'NotificationsController@unread',
    ]);

    Route::delete('/{id}', [
        'as'   => 'destroy',
        'uses' => 'NotificationsController@destroy',
    ]);

});