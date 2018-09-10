<?php

Route::group([
    'namespace'  => config('hegyd-news.controllers.backend_namespace'),
    'prefix'     => config('hegyd-news.routes.backend.prefix_route'),
    'middleware' => ['auth'],
], function () {

    /*
     * Backend News Category
     */
    Route::get('/actualites/categories', [
        'as'   => config('hegyd-news.routes.backend.news_category.index'),
        'uses' => 'NewsCategoriesController@index',
    ]);

    Route::get('/actualites/categories/creation', [
        'as'   => config('hegyd-news.routes.backend.news_category.create'),
        'uses' => 'NewsCategoriesController@create',
    ]);

    Route::post('/actualites/categories', [
        'as'   => config('hegyd-news.routes.backend.news_category.store'),
        'uses' => 'NewsCategoriesController@store',
    ]);

    Route::post('/actualites/categories/modal-creation', [
        'as'   => config('hegyd-news.routes.backend.news_category.create-from-modal'),
        'uses' => 'NewsCategoriesController@createFromModal',
    ]);

    Route::get('/actualites/categories/{id}/edition', [
        'as'   => config('hegyd-news.routes.backend.news_category.edit'),
        'uses' => 'NewsCategoriesController@edit',
    ]);

    Route::put('/actualites/categories/{id}', [
        'as'   => config('hegyd-news.routes.backend.news_category.update'),
        'uses' => 'NewsCategoriesController@update',
    ]);

    Route::put('/actualites/categories/{id}/toggle-active', [
        'as'   => config('hegyd-news.routes.backend.news_category.toggle-active'),
        'uses' => 'NewsCategoriesController@toggleActive',
    ]);

    Route::delete('/actualites/categories/{id}', [
        'as'   => config('hegyd-news.routes.backend.news_category.destroy'),
        'uses' => 'NewsCategoriesController@destroy',
    ]);

    /*
     * Backend News
     */
    Route::get('/actualites', [
        'as'   => config('hegyd-news.routes.backend.news.index'),
        'uses' => 'NewsController@index',
    ]);

    Route::get('/actualites/creation', [
        'as'   => config('hegyd-news.routes.backend.news.create'),
        'uses' => 'NewsController@create',
    ]);

    Route::post('/actualites', [
        'as'   => config('hegyd-news.routes.backend.news.store'),
        'uses' => 'NewsController@store',
    ]);

    Route::get('/actualites/{id}/edition', [
        'as'   => config('hegyd-news.routes.backend.news.edit'),
        'uses' => 'NewsController@edit',
    ]);

    Route::put('/actualites/{id}', [
        'as'   => config('hegyd-news.routes.backend.news.update'),
        'uses' => 'NewsController@update',
    ]);

    Route::put('/actualites/{id}/toggle-active', [
        'as'   => config('hegyd-news.routes.backend.news.toggle-active'),
        'uses' => 'NewsController@toggleActive',
    ]);

    Route::delete('/actualites/{id}', [
        'as'   => config('hegyd-news.routes.backend.news.destroy'),
        'uses' => 'NewsController@destroy',
    ]);
});

Route::group([
    'namespace'  => config('hegyd-news.controllers.backend_namespace'),
    'middleware' => ['auth']
], function () {
    Route::get('/commentaires/moderation', [
        'as'   => config('hegyd-news.routes.backend.report_comment.index'),
        'uses' => 'ReportCommentController@index',
    ]);

    Route::get('/commentaires/moderation/{id}', [
        'as'   => config('hegyd-news.routes.backend.report_comment.edit'),
        'uses' => 'ReportCommentController@edit',
    ]);

    Route::put('/commentaires/moderation/{id}', [
        'as'   => config('hegyd-news.routes.backend.report_comment.update'),
        'uses' => 'ReportCommentController@update',
    ]);

    Route::delete('/commentaires/moderation/{id}', [
        'as'   => config('hegyd-news.routes.backend.report_comment.destroy'),
        'uses' => 'ReportCommentController@destroy',
    ]);

    Route::get('/commentaires/moderation/{id}/signaler', [
        'as'   => config('hegyd-news.routes.backend.report_comment.get_send_mail'),
        'uses' => 'ReportCommentController@getSendMail',
    ]);

    Route::post('/commentaires/moderation/{id}', [
        'as'   => config('hegyd-news.routes.backend.report_comment.post_send_mail'),
        'uses' => 'ReportCommentController@postSendMail',
    ]);
});

Route::group(['namespace' => config('hegyd-news.controllers.backend_namespace'), 'middleware' => ['auth']], function () {
    Route::delete('/commentaires/{id}', [
        'as'   => config('hegyd-news.routes.backend.comments.destroy'),
        'uses' => 'CommentsController@destroy',
    ]);
});

Route::group(['namespace' => config('hegyd-news.controllers.frontend_namespace')], function () {
    Route::get('/actualites', [
        'as'   => config('hegyd-news.routes.frontend.news_category.index'),
        'uses' => 'NewsCategoriesController@index',
    ]);

    Route::get('/actualites/{slug}-cn{id}', [
        'as'   => config('hegyd-news.routes.frontend.news_category.show'),
        'uses' => 'NewsCategoriesController@show',
    ])->where(['slug' => '(.*)', 'id' => '[0-9]+']);

    Route::put('/actualites/{id}/like', [
        'as'   => config('hegyd-news.routes.frontend.news.like'),
        'uses' => 'NewsController@like',
    ]);

    Route::get('/actualites/{slug}-n{id}', [
        'as'   => config('hegyd-news.routes.frontend.news.show'),
        'uses' => 'NewsController@show',
    ])->where(['slug' => '(.*)', 'id' => '[0-9]+']);

    Route::group(['as' => config('hegyd-news.routes.frontend.prefix.comments'), 'prefix' => '/actualites/{id}/comment'], function () {
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