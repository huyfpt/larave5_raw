<?php

Route::group(['as' => 'homes.', 'namespace' => 'Common'], function ()
{
    Route::get('/', [
        'as'   => 'index',
        'uses' => 'HomeController@index'
    ]);

    Route::get('qui-sommes-nous', [
        'as'   => 'about',
        'uses' => 'HomeController@about'
    ]);

    Route::get('contact', [
        'as'   => 'contact',
        'uses' => 'HomeController@contact'
    ]);
    
    Route::post('contact/send', [
        'as'   => 'contact',
        'uses' => 'HomeController@sendEmail'
    ]);
    
    Route::get('profile', [
        'as'   => 'profile',
        'uses' => 'ProfileController@myProfile'
    ]);
    
    Route::post('profile', [
        'as'   => 'update-profile',
        'uses' => 'ProfileController@myProfileUpdate'
    ]);
});
