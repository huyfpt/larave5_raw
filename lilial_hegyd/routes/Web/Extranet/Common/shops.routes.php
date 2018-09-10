<?php

Route::group(['as' => 'shops.', 'prefix' => 'shops', 'namespace' => 'Common'], function ()
{
    Route::get('/search', [
        'as' => 'search',
        'uses' => 'ShopsController@search',
    ]);
});