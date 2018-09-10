<?php

Route::group([
    'namespace' => config('hegyd-seos.controllers.backend_namespace'),
    'prefix'    => config('hegyd-seos.routes.backend.prefix_route'),
    'middleware' => ['auth'],
], function ()
{

    Route::get('/seos/url_redirect', [
        'as'   => config('hegyd-seos.routes.backend.seo_url_redirects.index'),
        'uses' => 'SeoUrlRedirectsController@index',
    ]);

    Route::get('/seos/url_redirect/creation', [
        'as'   => config('hegyd-seos.routes.backend.seo_url_redirects.create'),
        'uses' => 'SeoUrlRedirectsController@create',
    ]);

    Route::post('/seos/url_redirect', [
        'as'   => config('hegyd-seos.routes.backend.seo_url_redirects.store'),
        'uses' => 'SeoUrlRedirectsController@store',
    ]);

    Route::post('/seos/url_redirect/modal-creation', [
        'as'   => config('hegyd-seos.routes.backend.seo_url_redirects.create-from-modal'),
        'uses' => 'SeoUrlRedirectsController@createFromModal',
    ]);

    Route::get('/seos/url_redirect/{id}/edition', [
        'as'   => config('hegyd-seos.routes.backend.seo_url_redirects.edit'),
        'uses' => 'SeoUrlRedirectsController@edit',
    ]);

    Route::put('/seos/url_redirect/{id}', [
        'as'   => config('hegyd-seos.routes.backend.seo_url_redirects.update'),
        'uses' => 'SeoUrlRedirectsController@update',
    ]);

    Route::put('/seos/url_redirect/{id}/toggle-active', [
        'as'   => config('hegyd-seos.routes.backend.seo_url_redirects.toggle-active'),
        'uses' => 'SeoUrlRedirectsController@toggleActive',
    ]);

    Route::delete('/seos/url_redirect/{id}', [
        'as'   => config('hegyd-seos.routes.backend.seo_url_redirects.destroy'),
        'uses' => 'SeoUrlRedirectsController@destroy',
    ]);
    /*
     * Backend seos
     */
    Route::get('/seos', [
        'as'   => config('hegyd-seos.routes.backend.seos.index'),
        'uses' => 'SeosController@index',
    ]);

    Route::get('/seos/creation', [
        'as'   => config('hegyd-seos.routes.backend.seos.create'),
        'uses' => 'SeosController@create',
    ]);

    Route::post('/seos', [
        'as'   => config('hegyd-seos.routes.backend.seos.store'),
        'uses' => 'SeosController@store',
    ]);

    Route::get('/seos/{id}/edition', [
        'as'   => config('hegyd-seos.routes.backend.seos.edit'),
        'uses' => 'SeosController@edit',
    ]);

    Route::put('/seos/{id}', [
        'as'   => config('hegyd-seos.routes.backend.seos.update'),
        'uses' => 'SeosController@update',
    ]);

    Route::put('/seos/{id}/toggle-active', [
        'as'   => config('hegyd-seos.routes.backend.seos.toggle-active'),
        'uses' => 'SeosController@toggleActive',
    ]);

    Route::delete('/seos/{id}', [
        'as'   => config('hegyd-seos.routes.backend.seos.destroy'),
        'uses' => 'SeosController@destroy',
    ]);
});
