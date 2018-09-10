<?php

Route::group([
    'namespace' => config('hegyd-pages.controllers.backend_namespace'),
    'prefix'    => config('hegyd-pages.routes.backend.prefix_route'),
    'middleware' => ['auth'],
], function ()
{

    /*
     * Backend pages
     */
    Route::get('/pages', [
        'as'   => config('hegyd-pages.routes.backend.pages.index'),
        'uses' => 'PagesController@index',
    ]);

    Route::get('/pages/creation', [
        'as'   => config('hegyd-pages.routes.backend.pages.create'),
        'uses' => 'PagesController@create',
    ]);

    Route::post('/pages', [
        'as'   => config('hegyd-pages.routes.backend.pages.store'),
        'uses' => 'PagesController@store',
    ]);

    Route::get('/pages/{id}/edition', [
        'as'   => config('hegyd-pages.routes.backend.pages.edit'),
        'uses' => 'PagesController@edit',
    ]);

    Route::put('/pages/{id}', [
        'as'   => config('hegyd-pages.routes.backend.pages.update'),
        'uses' => 'PagesController@update',
    ]);

    Route::put('/pages/{id}/toggle-active', [
        'as'   => config('hegyd-pages.routes.backend.pages.toggle-active'),
        'uses' => 'PagesController@toggleActive',
    ]);

    Route::delete('/pages/{id}', [
        'as'   => config('hegyd-pages.routes.backend.pages.destroy'),
        'uses' => 'PagesController@destroy',
    ]);
});

Route::group([
    'namespace' => config('hegyd-pages.controllers.frontend_namespace'),
    'prefix'    => config('hegyd-pages.routes.frontend.prefix_route'),
], function ()
{
    /*
     * Front pages
     */
    Route::get('/pages', [
        'as'   => config('hegyd-pages.routes.frontend.pages.index'),
        'uses' => 'PagesController@index',
    ]);
    Route::get('/pages/{slug}', [
        'as'   => config('hegyd-pages.routes.frontend.pages.show'),
        'uses' => 'PagesController@show',
    ]);
});
