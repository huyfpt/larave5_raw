<?php


Route::group(['as' => 'clients.', 'prefix' => 'clients', 'namespace' => 'Common'], function ()
{

    Route::get('/', [
        'as'   => 'index',
        'uses' => 'ClientsController@index',
    ]);

    Route::get('/{id}/edition', [
        'as'   => 'edit',
        'uses' => 'ClientsController@edit',
    ]);

    Route::put('/{id}', [
        'as'   => 'update',
        'uses' => 'ClientsController@update',
    ]);

    Route::get('/creation', [
        'as'   => 'create',
        'uses' => 'ClientsController@create',
    ]);

    Route::post('/creation', [
        'as'   => 'store',
        'uses' => 'ClientsController@store',
    ]);

    Route::delete('/{id}', [
        'as'   => 'destroy',
        'uses' => 'ClientsController@destroy',
    ]);
    
    Route::group(['as' => 'bulk.', 'prefix' => 'bulk'], function ()
    {
        Route::get('/active', [
            'as'   => 'active',
            'uses' => 'ClientsController@bulkActive',
        ]);
        Route::get('/unactive', [
            'as'   => 'unactive',
            'uses' => 'ClientsController@bulkUnactive',
        ]);
        Route::get('/delete', [
            'as'   => 'delete',
            'uses' => 'ClientsController@bulkDelete',
        ]);
        Route::get('/force-reset-password', [
            'as'   => 'force-reset-password',
            'uses' => 'ClientsController@bulkForceResetPassword',
        ]);
    });

    Route::get('search-ajax', [
        'as'   => 'search-ajax',
        'uses' => 'ClientsController@searchAjax'
    ]);

    Route::get('multi/{ids?}', [
        'as'   => 'multi',
        'uses' => 'ClientsController@showMulti'
    ]);

    Route::put('{id}/toggle-active', [
        'as'   => 'toggle-active',
        'uses' => 'UsersController@toggleActive',
    ]);

    Route::put('{id}/force-reset-password', [
        'as'   => 'force-reset-password',
        'uses' => 'ClientsController@forceResetPassword',
    ]);

    Route::group(['as' => 'export.', 'prefix' => 'export'], function ()
    {
        Route::get('excel', [
            'as'   => 'excel',
            'uses' => 'ClientsController@exportExcel'
        ]);
    });

    Route::group(['as' => 'import.', 'prefix' => 'import'], function ()
    {
        Route::post('excel', [
            'as'   => 'excel',
            'uses' => 'ClientsController@importExcel'
        ]);
    });
});
