<?php
Route::group(['namespace' => 'Common\Common'], function(){
    Route::get('/media/download/{upload_id}/{filename}', [
        'as'   => 'medias.download',
        'uses' => 'MediaController@download',
    ]);

    Route::get('/media/show/{upload_id}/{filename}', [
        'as'   => 'medias.show',
        'uses' => 'MediaController@show',
    ]);
    Route::get('/media/{upload_id}/{size_type}/{size}/{color}/{image_name}', [
        'as'   => 'medias.get',
        'uses' => 'MediaController@get',
    ]);


    Route::group(['prefix' => 'countries'], function ()
    {
        Route::get('/', 'CountriesController@index');
        Route::get('/{id}', 'CountriesController@show');
    });
    Route::group(['prefix' => 'cities'], function ()
    {
        Route::get('/', 'CitiesController@index');
        Route::get('/{id}', 'CitiesController@show');
    });
});