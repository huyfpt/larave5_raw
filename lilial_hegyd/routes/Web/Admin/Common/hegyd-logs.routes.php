<?php


Route::group(['namespace' => 'Common', 'prefix' => 'logs'], function ()
{
    Route::match(['get', 'post'], '/', [
        'uses' => 'LogsController@index',
        'as'   => 'logs.index',
    ]);

    Route::match(['get', 'post'], '/exportexcel', [
        'uses' => 'LogsController@exportExcel',
        'as'   => 'logs.export-excel',
    ]);

    Route::match(['get', 'post'], '/exportcsv', [
        'uses' => 'LogsController@exportCsv',
        'as'   => 'logs.export-csv',
    ]);

});
