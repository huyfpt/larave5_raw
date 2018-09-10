<?php

return [

    /*
   |--------------------------------------------------------------------------
   | Hegyd Pages Model
   |--------------------------------------------------------------------------
   |
   | This is the Pages model used to create correct relations.  Update
   | the Pages if it is in a different namespace.
   |
   */
    'models'         => [
        'pages'                 => \Hegyd\Pages\Models\Pages::class,
        'user'                  => \App\User::class,
    ],
    
    'services'  => [
        'extranet'   => 'App\Services\Common\ExtranetService',
        'pages'      => \Hegyd\Pages\Services\PagesService::class,
    ],

    'filters' => [
        'pages' => Hegyd\Pages\Repositories\Filters\FilterPages::class,
    ],
    'administrators' => [
        'super_admin',
        'admin'
    ],

    'repository' => [
        'pages' => \Hegyd\Pages\Repositories\Contracts\PagesRepositoryInterface::class,
        'users' => \App\Repositories\Contracts\Common\UserRepositoryInterface::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Hegyd Pages Table
    |--------------------------------------------------------------------------
    |
    | This is the Pages table used to save Pages to the database.
    |
    */
    'tables'         => [
        'pages'          => 'pages',
        'role'          => 'roles',
    ],

    /*
    |--------------------------------------------------------------------------
    | Hegyd Pages main layout
    |--------------------------------------------------------------------------
    |
    | This is the main layout where is display the views.
    | Ex :
    |   @extends('main_layout')
    |
    */
    'main_layout'    => [
        'frontend' => 'layouts.front',
        'backend'  => 'layouts.app',
    ],

    /*
    |--------------------------------------------------------------------------
    | Hegyd Pages view namespace
    |--------------------------------------------------------------------------
    |
    | This is the view namespace for breadcrumb
    |
    */
    'view-namespace' => [
        'frontend' => 'front',
        'backend'  => 'app',
    ],

    /*
    |--------------------------------------------------------------------------
    | Hegyd Pages controllers package
    |--------------------------------------------------------------------------
    |
    |
    */
    'controllers'    => [
        'backend_namespace'  => 'Hegyd\\Pages\\Controllers\\Backend',
        'frontend_namespace' => 'Hegyd\\Pages\\Controllers\\Frontend',
    ],

    /*
    |--------------------------------------------------------------------------
    | Hegyd Pages routes package
    |--------------------------------------------------------------------------
    |
    |
    */
    'routes'         => [
        'backend'  => [
            'prefix_route'  => 'admin',
            'prefix'        => [
                'pages'          => 'admin.pages.',
            ],
            'pages'          => [
                'index'         => 'admin.pages.index',
                'create'        => 'admin.pages.create',
                'store'         => 'admin.pages.store',
                'edit'          => 'admin.pages.edit',
                'update'        => 'admin.pages.update',
                'toggle-active' => 'admin.pages.toggle-active',
                'destroy'       => 'admin.pages.destroy',
            ],
        ],
        'frontend' => [
            'prefix_route'  => '',
            'prefix'        => [
                'pages'          => 'frontend.pages.',
            ],
            'pages' => [
                'index' => 'pages.index'
            ],
        ],
    ],

    'enable_comment' => true,
    

    'permissions' => [
        'prefix'        => [
            'backend'   => [
                'pages'          => 'admin.pages.',
            ],
            'frontend'   => [
                'pages'          => 'frontend.pages.',
            ],
        ],
        'backend'   => [
            'pages' => [
                'create' => 'admin.pages.create',
                'edit'   => 'admin.pages.edit',
            ],
        ],
        'frontend' => [
            'pages' => [
                'show'      => 'frontend.pages.show',
            ],
        ],
    ],
];