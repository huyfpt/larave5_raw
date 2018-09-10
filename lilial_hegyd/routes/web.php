<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::get('/', 'Front\HomeController@index')->name('home.index');
Route::get('/about/{slug}', 'Front\HomeController@about')->name('home.about');
Route::get('/contact', 'Front\HomeController@contact')->name('home.contact');

Route::group(['prefix' => '/club'], function() {
    Route::get('', 'Front\ClubController@index')->name('home.club.index');
    Route::get('/news', 'Front\ClubController@news')->name('home.club.news');
    Route::get('/news/{slug}', 'Front\ClubController@newsShow')->name('home.club.news.show');
    Route::get('/ambassadors', 'Front\ClubController@ambassadors')->name('home.club.ambassadors');
});

Route::get('/product', 'Front\HomeController@product')->name('home.product');
Route::get('/product/detail', 'Front\HomeController@productShow')->name('home.product.detail');
Route::get('/product-detail', 'Front\HomeController@productDetail')->name('home.product-detail');
Route::get('/profile', 'Front\HomeController@profile')->name('home.profile');

Route::group([], function(){
    RoutesTools::includeRoutes('Web');
});

Route::group([], function(){
    RoutesTools::includeRoutes('Front');
});