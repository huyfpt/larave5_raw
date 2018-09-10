<?php

/*Route::group(['namespace' => 'Backend\Common', 'prefix' => 'admin/utilisateurs'], function ()
{
    Route::get('/',
        [
            'uses' => 'UsersController@index',
            'as'   => 'permissions.index',
        ]
    );

});*/

Route::group(['as' => 'users.', 'prefix' => 'utilisateurs', 'namespace' => 'Common'], function ()
{
//    Route::get('search', [
//        'as'   => 'search',
//        'uses' => 'UsersController@search'
//    ]);
//
    Route::get('search-ajax', [
        'as'   => 'search-ajax',
        'uses' => 'UsersController@searchAjax'
    ]);

    Route::get('multi/{ids?}', [
        'as'   => 'multi',
        'uses' => 'UsersController@showMulti'
    ]);

    Route::put('{id}/toggle-active', [
        'as'   => 'toggle-active',
        'uses' => 'UsersController@toggleActive',
    ]);

    Route::put('{id}/force-reset-password', [
        'as'   => 'force-reset-password',
        'uses' => 'UsersController@forceResetPassword',
    ]);

    Route::group(['as' => 'export.', 'prefix' => 'export'], function ()
    {
        Route::get('excel', [
            'as'   => 'excel',
            'uses' => 'UsersController@exportExcel'
        ]);
    });

    Route::group(['as' => 'bulk.', 'prefix' => 'bulk'], function ()
    {
        Route::get('/active', [
            'as'   => 'active',
            'uses' => 'UsersController@bulkActive',
        ]);
        Route::get('/unactive', [
            'as'   => 'unactive',
            'uses' => 'UsersController@bulkUnactive',
        ]);
        Route::get('/delete', [
            'as'   => 'delete',
            'uses' => 'UsersController@bulkDelete',
        ]);
        Route::get('/force-reset-password', [
            'as'   => 'force-reset-password',
            'uses' => 'UsersController@bulkForceResetPassword',
        ]);
    });

    Route::get('/', [
        'as'   => 'index',
        'uses' => 'UsersController@index',
    ]);

    Route::get('/{id}/edition', [
        'as'   => 'edit',
        'uses' => 'UsersController@edit',
    ]);

    Route::put('/{id}', [
        'as'   => 'update',
        'uses' => 'UsersController@update',
    ]);

    Route::get('/creation', [
        'as'   => 'create',
        'uses' => 'UsersController@create',
    ]);

    Route::post('/creation', [
        'as'   => 'store',
        'uses' => 'UsersController@store',
    ]);

    Route::delete('/{id}', [
        'as'   => 'destroy',
        'uses' => 'UsersController@destroy',
    ]);

    Route::get('/{id}/se-connecter-en-tant-que', [
        'uses' => 'UsersController@loginAs',
        'as'   => 'loginas',
    ])->where('id', '[0-9]+');

    Route::get('/se-deconnecter-en-tant-que', [
        'uses' => 'UsersController@logoutAs',
        'as'   => 'logoutas',
    ]);
});
