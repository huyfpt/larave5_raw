<?php

Route::group([
    'namespace' => config('hegyd-faqs.controllers.backend_namespace'),
    'prefix'    => config('hegyd-faqs.routes.backend.prefix_route')
], function ()
{

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
    Route::match(['get', 'post'], '/exportexcel', [
        'uses' => 'NewslettersController@exportExcel',
        'as'   => config('hegyd-faqs.routes.backend.newsletters.export-excel'),
    ]);

    Route::match(['get', 'post'], '/exportcsv', [
        'uses' => 'NewslettersController@exportCsv',
        'as'   => config('hegyd-faqs.routes.backend.newsletters.export-csv'),
    ]);
});

Route::group(['namespace' => config('hegyd-faqs.controllers.backend_namespace'),'middleware' => ['auth']], function ()
{
    Route::get('/commentaires/moderation', [
        'as'   => config('hegyd-faqs.routes.backend.report_comment.index'),
        'uses' => 'ReportCommentController@index',
    ]);

    Route::get('/commentaires/moderation/{id}', [
        'as'   => config('hegyd-faqs.routes.backend.report_comment.edit'),
        'uses' => 'ReportCommentController@edit',
    ]);

    Route::put('/commentaires/moderation/{id}', [
        'as'   => config('hegyd-faqs.routes.backend.report_comment.update'),
        'uses' => 'ReportCommentController@update',
    ]);

    Route::delete('/commentaires/moderation/{id}', [
        'as'   => config('hegyd-faqs.routes.backend.report_comment.destroy'),
        'uses' => 'ReportCommentController@destroy',
    ]);

    Route::get('/commentaires/moderation/{id}/signaler', [
        'as'   => config('hegyd-faqs.routes.backend.report_comment.get_send_mail'),
        'uses' => 'ReportCommentController@getSendMail',
    ]);

    Route::post('/commentaires/moderation/{id}', [
        'as'   => config('hegyd-faqs.routes.backend.report_comment.post_send_mail'),
        'uses' => 'ReportCommentController@postSendMail',
    ]);
});

Route::group(['namespace' => config('hegyd-faqs.controllers.backend_namespace'),'middleware' => ['auth']], function ()
{
    Route::delete('/commentaires/{id}', [
        'as'   => config('hegyd-faqs.routes.backend.comments.destroy'),
        'uses' => 'CommentsController@destroy',
    ]);
});

Route::group(['namespace' => config('hegyd-faqs.controllers.frontend_namespace')], function ()
{
    Route::get('/faqs', [
        'as'   => config('hegyd-faqs.routes.frontend.faqs_category.index'),
        'uses' => 'FaqsCategoriesController@index',
    ]);

    Route::get('/faqs/{slug}-cn{id}', [
        'as'   => config('hegyd-faqs.routes.frontend.faqs_category.show'),
        'uses' => 'FaqsCategoriesController@show',
    ])->where(['slug' => '(.*)', 'id' => '[0-9]+']);

    Route::put('/faqs/{id}/like', [
        'as'   => config('hegyd-faqs.routes.frontend.faqs.like'),
        'uses' => 'FaqsController@like',
    ]);

    Route::get('/faqs/{slug}', [
        'as'   => config('hegyd-faqs.routes.frontend.faqs.show'),
        'uses' => 'FaqsController@show',
    ])->where(['slug' => '(.*)', 'id' => '[0-9]+']);

    Route::group(['as' => 'frontend.comments.', 'prefix' => '/faqs/{id}/comment'], function ()
    {
        Route::get('/edition/{comment_id}', [
            'as'   => 'edit-from-modal',
            'uses' => 'CommentsController@editComment',
        ]);

        Route::put('/edition/{comment_id}', [
            'as'   => 'update-from-modal',
            'uses' => 'CommentsController@updateComment',
        ]);
        Route::delete('/suppression/{comment_id}', [
            'as'   => 'destroy',
            'uses' => 'CommentsController@destroyChapter',
        ]);

        Route::get('/creation', [
            'as'   => 'create-from-modal',
            'uses' => 'CommentsController@getCreateCommentFromModal',
        ]);

        Route::post('/creation', [
            'as'   => 'save-from-modal',
            'uses' => 'CommentsController@createFromModalComment',
        ]);

        Route::get('/signaler/{comment_id}', [
            'as'   => 'get-report',
            'uses' => 'CommentsController@getReportComment',
        ]);

        Route::post('/signaler/{comment_id}', [
            'as'   => 'report',
            'uses' => 'CommentsController@reportComment',
        ]);
    });
});

Route::group(['as' => 'roles.', 'prefix' => 'roles', 'namespace' => 'ACL'], function ()
{
    Route::get('/search', [
        'as' => 'search',
        'uses' => 'RolesController@search',
    ]);
});