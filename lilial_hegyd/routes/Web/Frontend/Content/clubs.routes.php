<?php

Route::group(['as' => 'clubs.', 'prefix' => 'club/', 'namespace' => 'Content'], function ()
{
    Route::get('/', [
        'as'   => 'index',
        'uses' => 'ClubController@index'
    ]);

    Route::get('actualites', [
        'as'   => 'news.index',
        'uses' => 'ClubController@listNews'
    ]);

    Route::get('actualites/{slug}', [
        'as'   => 'news.show',
        'uses' => 'ClubController@showNews'
    ]);

    Route::get('ambassadors', [
        'as'   => 'ambassadors.index',
        'uses' => 'ClubController@listAmbassadors'
    ]);

    Route::get('ambassadors/{slug}', [
        'as'   => 'ambassadors.show',
        'uses' => 'ClubController@listAmbassadors'
    ]);
});
