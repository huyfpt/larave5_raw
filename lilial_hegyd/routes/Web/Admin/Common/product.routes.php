<?php


Route::group(['prefix' => 'product', 'namespace' => 'Content'], function ()
{

    Route::get('/category', [
        'as'   => 'index',
        'uses' => 'ProductCategoriesController@index',
    ]);
});
