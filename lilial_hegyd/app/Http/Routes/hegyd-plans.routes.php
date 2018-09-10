<?php

Route::group([
    'namespace' => config('hegyd-plans.controllers.backend_namespace'),
    'prefix'    => config('hegyd-plans.routes.backend.prefix_route')
], function ()
{

    /*
     * Backend News Category
     */
    Route::get('/plans/categories', [
        'as'   => config('hegyd-plans.routes.backend.plans_category.index'),
        'uses' => 'PlansCategoriesController@index',
    ]);

    Route::get('/plans/categories/creation', [
        'as'   => config('hegyd-plans.routes.backend.plans_category.create'),
        'uses' => 'PlansCategoriesController@create',
    ]);

    Route::post('/plans/categories', [
        'as'   => config('hegyd-plans.routes.backend.plans_category.store'),
        'uses' => 'PlansCategoriesController@store',
    ]);

    Route::post('/plans/categories/modal-creation', [
        'as'   => config('hegyd-plans.routes.backend.plans_category.create-from-modal'),
        'uses' => 'PlansCategoriesController@createFromModal',
    ]);

    Route::get('/plans/categories/{id}/edition', [
        'as'   => config('hegyd-plans.routes.backend.plans_category.edit'),
        'uses' => 'PlansCategoriesController@edit',
    ]);

    Route::put('/plans/categories/{id}', [
        'as'   => config('hegyd-plans.routes.backend.plans_category.update'),
        'uses' => 'PlansCategoriesController@update',
    ]);

    Route::put('/plans/categories/{id}/toggle-active', [
        'as'   => config('hegyd-plans.routes.backend.plans_category.toggle-active'),
        'uses' => 'PlansCategoriesController@toggleActive',
    ]);

    Route::delete('/plans/categories/{id}', [
        'as'   => config('hegyd-plans.routes.backend.plans_category.destroy'),
        'uses' => 'PlansCategoriesController@destroy',
    ]);


    /*
     * Backend plans
     */
    Route::get('/plans', [
        'as'   => config('hegyd-plans.routes.backend.plans.index'),
        'uses' => 'PlansController@index',
    ]);

    Route::get('/plans/creation', [
        'as'   => config('hegyd-plans.routes.backend.plans.create'),
        'uses' => 'PlansController@create',
    ]);

    Route::post('/plans', [
        'as'   => config('hegyd-plans.routes.backend.plans.store'),
        'uses' => 'PlansController@store',
    ]);

    Route::get('/plans/{id}/edition', [
        'as'   => config('hegyd-plans.routes.backend.plans.edit'),
        'uses' => 'PlansController@edit',
    ]);

    Route::put('/plans/{id}', [
        'as'   => config('hegyd-plans.routes.backend.plans.update'),
        'uses' => 'PlansController@update',
    ]);

    Route::put('/plans/{id}/toggle-active', [
        'as'   => config('hegyd-plans.routes.backend.plans.toggle-active'),
        'uses' => 'PlansController@toggleActive',
    ]);

    Route::delete('/plans/{id}', [
        'as'   => config('hegyd-plans.routes.backend.plans.destroy'),
        'uses' => 'PlansController@destroy',
    ]);
});
