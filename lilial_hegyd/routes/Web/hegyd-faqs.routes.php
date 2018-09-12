<?php

Route::group([
    'namespace'  => config('hegyd-faqs.controllers.backend_namespace'),
    'prefix'     => config('hegyd-faqs.routes.backend.prefix_route'),
    'middleware' => ['auth'],
], function () {

    /*
     * Backend Faqs Category
     */
    Route::get('/faqs/categories', [
        'as'   => config('hegyd-faqs.routes.backend.faqs_category.index'),
        'uses' => 'FaqsCategoriesController@index',
    ]);

    Route::get('/faqs/categories/creation', [
        'as'   => config('hegyd-faqs.routes.backend.faqs_category.create'),
        'uses' => 'FaqsCategoriesController@create',
    ]);

    Route::post('/faqs/categories', [
        'as'   => config('hegyd-faqs.routes.backend.faqs_category.store'),
        'uses' => 'FaqsCategoriesController@store',
    ]);

    Route::post('/faqs/categories/modal-creation', [
        'as'   => config('hegyd-faqs.routes.backend.faqs_category.create-from-modal'),
        'uses' => 'FaqsCategoriesController@createFromModal',
    ]);

    Route::get('/faqs/categories/{id}/edition', [
        'as'   => config('hegyd-faqs.routes.backend.faqs_category.edit'),
        'uses' => 'FaqsCategoriesController@edit',
    ]);

    Route::put('/faqs/categories/{id}', [
        'as'   => config('hegyd-faqs.routes.backend.faqs_category.update'),
        'uses' => 'FaqsCategoriesController@update',
    ]);

    Route::put('/faqs/categories/{id}/toggle-active', [
        'as'   => config('hegyd-faqs.routes.backend.faqs_category.toggle-active'),
        'uses' => 'FaqsCategoriesController@toggleActive',
    ]);

    Route::delete('/faqs/categories/{id}', [
        'as'   => config('hegyd-faqs.routes.backend.faqs_category.destroy'),
        'uses' => 'FaqsCategoriesController@destroy',
    ]);

    /*
     * Backend Faqs
     */
    Route::get('/faqs', [
        'as'   => config('hegyd-faqs.routes.backend.faqs.index'),
        'uses' => 'FaqsController@index',
    ]);

    Route::get('/faqs/creation', [
        'as'   => config('hegyd-faqs.routes.backend.faqs.create'),
        'uses' => 'FaqsController@create',
    ]);

    Route::post('/faqs', [
        'as'   => config('hegyd-faqs.routes.backend.faqs.store'),
        'uses' => 'FaqsController@store',
    ]);

    Route::get('/faqs/{id}/edition', [
        'as'   => config('hegyd-faqs.routes.backend.faqs.edit'),
        'uses' => 'FaqsController@edit',
    ]);

    Route::put('/faqs/{id}', [
        'as'   => config('hegyd-faqs.routes.backend.faqs.update'),
        'uses' => 'FaqsController@update',
    ]);

    Route::put('/faqs/{id}/toggle-active', [
        'as'   => config('hegyd-faqs.routes.backend.faqs.toggle-active'),
        'uses' => 'FaqsController@toggleActive',
    ]);

    Route::delete('/faqs/{id}', [
        'as'   => config('hegyd-faqs.routes.backend.faqs.destroy'),
        'uses' => 'FaqsController@destroy',
    ]);

    Route::get('/faqs/ajax-list-faq', [
        'as'   => config('hegyd-faqs.routes.backend.faqs.ajax-list-faq'),
        'uses' => 'FaqsController@ajaxListFaq',
    ]);

    /*
     * Backend Newsletter
     */
    Route::get('/newsletters', [
        'as'   => config('hegyd-faqs.routes.backend.newsletters.index'),
        'uses' => 'NewslettersController@index',
    ]);

    Route::get('/newsletters/creation', [
        'as'   => config('hegyd-faqs.routes.backend.newsletters.create'),
        'uses' => 'NewslettersController@create',
    ]);

    Route::post('/newsletters', [
        'as'   => config('hegyd-faqs.routes.backend.newsletters.store'),
        'uses' => 'NewslettersController@store',
    ]);

    Route::get('/newsletters/{id}/edition', [
        'as'   => config('hegyd-faqs.routes.backend.newsletters.edit'),
        'uses' => 'NewslettersController@edit',
    ]);

    Route::put('/newsletters/{id}', [
        'as'   => config('hegyd-faqs.routes.backend.newsletters.update'),
        'uses' => 'NewslettersController@update',
    ]);

    Route::put('/newsletters/{id}/toggle-active', [
        'as'   => config('hegyd-faqs.routes.backend.newsletters.toggle-active'),
        'uses' => 'NewslettersController@toggleActive',
    ]);

    Route::delete('/newsletters/{id}', [
        'as'   => config('hegyd-faqs.routes.backend.newsletters.destroy'),
        'uses' => 'NewslettersController@destroy',
    ]);

    Route::match(['get', 'post'], '/newsletters/exportexcel', [
        'uses' => 'NewslettersController@exportExcel',
        'as'   => config('hegyd-faqs.routes.backend.newsletters.export-excel'),
    ]);

    Route::match(['get', 'post'], '/newsletters/exportcsv', [
        'uses' => 'NewslettersController@exportCsv',
        'as'   => config('hegyd-faqs.routes.backend.newsletters.export-csv'),
    ]);
});

Route::group([
    'namespace'  => config('hegyd-faqs.controllers.backend_namespace'),
    'middleware' => ['auth']
], function () {
    // Route::get('/commentaires/moderation', [
    //     'as'   => config('hegyd-faqs.routes.backend.report_comment.index'),
    //     'uses' => 'ReportCommentController@index',
    // ]);

    // Route::get('/commentaires/moderation/{id}', [
    //     'as'   => config('hegyd-faqs.routes.backend.report_comment.edit'),
    //     'uses' => 'ReportCommentController@edit',
    // ]);

    // Route::put('/commentaires/moderation/{id}', [
    //     'as'   => config('hegyd-faqs.routes.backend.report_comment.update'),
    //     'uses' => 'ReportCommentController@update',
    // ]);

    // Route::delete('/commentaires/moderation/{id}', [
    //     'as'   => config('hegyd-faqs.routes.backend.report_comment.destroy'),
    //     'uses' => 'ReportCommentController@destroy',
    // ]);

    // Route::get('/commentaires/moderation/{id}/signaler', [
    //     'as'   => config('hegyd-faqs.routes.backend.report_comment.get_send_mail'),
    //     'uses' => 'ReportCommentController@getSendMail',
    // ]);

    // Route::post('/commentaires/moderation/{id}', [
    //     'as'   => config('hegyd-faqs.routes.backend.report_comment.post_send_mail'),
    //     'uses' => 'ReportCommentController@postSendMail',
    // ]);
});


/**
 * Frontend route
 */
Route::group(['namespace' => config('hegyd-faqs.controllers.frontend_namespace')], function () {
    Route::get('/faqs', [
        'as'   => config('hegyd-faqs.routes.frontend.faqs.index'),
        'uses' => 'FaqsController@index',
    ]);
    Route::get('/faqs/category/{slug}-n{id}', [
        'as'   => config('hegyd-faqs.routes.frontend.faqs_category.show_list'),
        'uses' => 'FaqsCategoriesController@showList',
    ])->where(['slug' => '(.*)', 'id' => '[0-9]+']);

    Route::get('/faqs/{slug}', [
        'as'   => config('hegyd-faqs.routes.frontend.faqs.show'),
        'uses' => 'FaqsController@show',
    ])->where(['slug' => '(.*)', 'id' => '[0-9]+']);

    Route::get('/faqs_category/{slug}-n{id}', [
        'as'   => config('hegyd-faqs.routes.frontend.faqs_category.show'),
        'uses' => 'FaqsCategoriesController@show',
    ])->where(['slug' => '(.*)', 'id' => '[0-9]+']);
    Route::post('/newsletters/create-from-modal', [
        'as'   => config('hegyd-faqs.routes.frontend.newsletters.create-from-modal'),
        'uses' => 'NewslettersController@store',
    ]);

    Route::post('/newsletters/create-from-form', [
        'as'   => config('hegyd-faqs.routes.frontend.newsletters.create-from-form'),
        'uses' => 'NewslettersController@ajaxSave',
    ]);
});

Route::group(['as' => 'roles.', 'prefix' => 'roles', 'namespace' => 'ACL'], function () {
    Route::get('/search', [
        'as'   => 'search',
        'uses' => 'RolesController@search',
    ]);
});