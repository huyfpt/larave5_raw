<?php

Route::group(['as' => 'shops.', 'prefix' => config('app.shop_label'), 'namespace' => 'Common'], function ()
{
//    Route::get('search', [
//        'as'   => 'search',
//        'uses' => 'ShopsController@search'
//    ]);
//
/*    Route::get('search-ajax', [
        'as'   => 'search-ajax',
        'uses' => 'ShopsController@searchAjax'
    ]);*/

/*    Route::get('multi/{ids?}', [
        'as'   => 'multi',
        'uses' => 'ShopsController@showMulti'
    ]);*/

    Route::put('{id}/toggle-active', [
        'as'   => 'toggle-active',
        'uses' => 'ShopsController@toggleActive',
    ]);

    Route::group(['as' => 'export.', 'prefix' => 'export'], function ()
    {
        Route::get('excel', [
            'as'   => 'excel',
            'uses' => 'ShopsController@exportExcel'
        ]);
    });

    Route::group(['as' => 'bulk.', 'prefix' => 'bulk'], function ()
    {
        Route::get('/active', [
            'as'   => 'active',
            'uses' => 'ShopsController@bulkActive',
        ]);
        Route::get('/unactive', [
            'as'   => 'unactive',
            'uses' => 'ShopsController@bulkUnactive',
        ]);
        Route::get('/delete', [
            'as'   => 'delete',
            'uses' => 'ShopsController@bulkDelete',
        ]);
    });

    Route::get('/', [
        'as'   => 'index',
        'uses' => 'ShopsController@index',
    ]);

    Route::get('/{id}/edition', [
        'as'   => 'edit',
        'uses' => 'ShopsController@edit',
    ]);

    Route::put('/{id}', [
        'as'   => 'update',
        'uses' => 'ShopsController@update',
    ]);

    Route::get('/creation', [
        'as'   => 'create',
        'uses' => 'ShopsController@create',
    ]);

    Route::post('/creation', [
        'as'   => 'store',
        'uses' => 'ShopsController@store',
    ]);

    Route::delete('/{id}', [
        'as'   => 'destroy',
        'uses' => 'ShopsController@destroy',
    ]);

});
