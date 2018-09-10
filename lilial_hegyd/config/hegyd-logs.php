<?php


return [

    /*
   |--------------------------------------------------------------------------
   | Hegyd Logs Model
   |--------------------------------------------------------------------------
   |
   | This is the Log model used to create correct relations.  Update
   | the log if it is in a different namespace.
   |
   */
    'log_model'   => 'Hegyd\Logs\Models\Log',
    'user_model'  => App\Models\Common\User::class,

    /*
    |--------------------------------------------------------------------------
    | Hegyd Logs Table
    |--------------------------------------------------------------------------
    |
    | This is the logs table used to save logs to the database.
    |
    */
    'logs_table'  => 'logs',

    /*
    |--------------------------------------------------------------------------
    | Hegyd Logs main layout
    |--------------------------------------------------------------------------
    |
    | This is the main layout where is display the views.
    | Ex :
    |   @extends('main_layout')
    |
    */
    'main_layout' => 'layouts.app',


    'routes' => [
        'index'  => 'admin.logs.index',
    ],

    'acl' => [
        'backend'   => [
            'index'     => 'admin.logs.index',
            'export'    => 'admin.logs.export',
        ],
    ],

];