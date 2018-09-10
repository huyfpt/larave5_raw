<?php

Route::group(['as' => 'auth.'], function ()
{
    /* COPY FROM Illuminate\Routing\Router@auth() */
    // Authentication Routes...
    Route::get('connexion', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('connexion', 'Auth\LoginController@login')->name('postLogin');

    Route::get('deconnexion', 'Auth\LoginController@logout')->name('logout');

    // Password Reset Routes...
    Route::get('mot-de-passe-oublie', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.getRequest');
    Route::post('mot-de-passe-oublie', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.postRequest');

    Route::get('reinitialisation-mot-de-passe/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.getReset');
    Route::post('reinitialisation-mot-de-passe', 'Auth\ResetPasswordController@reset')->name('password.postReset');

});