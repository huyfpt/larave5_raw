<?php

return [

    /*
   |--------------------------------------------------------------------------
   | Hegyd seos Model
   |--------------------------------------------------------------------------
   |
   | This is the seos model used to create correct relations.  Update
   | the seos if it is in a different namespace.
   |
   */
    'models'         => [
        'seos'                 => \Hegyd\Seos\Models\Seos::class,
        'seo_url_redirects'    => \Hegyd\Seos\Models\SeoUrlRedirects::class,
        'user'                 => \App\User::class,
    ],
    
    'services'  => [
        'extranet'   => 'App\Services\Common\ExtranetService',
        'seos'      => \Hegyd\Seos\Services\SeosService::class,
    ],

    'filters' => [
        'seos' => Hegyd\Seos\Repositories\Filters\FilterSeos::class,
    ],
    'administrators' => [
        'super_admin',
        'admin'
    ],

    'repository' => [
        'seos' => \Hegyd\Seos\Repositories\Contracts\SeosRepositoryInterface::class,
        'users' => \App\Repositories\Contracts\Common\UserRepositoryInterface::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Hegyd seos Table
    |--------------------------------------------------------------------------
    |
    | This is the seos table used to save seos to the database.
    |
    */
    'tables'         => [
        'seos'          => 'seos',
        'seo_url_redirects' => 'seo_url_redirects',
        'role'          => 'roles',
    ],

    /*
    |--------------------------------------------------------------------------
    | Hegyd seos main layout
    |--------------------------------------------------------------------------
    |
    | This is the main layout where is display the views.
    | Ex :
    |   @extends('main_layout')
    |
    */
    'main_layout'    => [
        'frontend' => 'app',
        'backend'  => 'layouts.app',
    ],

    /*
    |--------------------------------------------------------------------------
    | Hegyd seos view namespace
    |--------------------------------------------------------------------------
    |
    | This is the view namespace for breadcrumb
    |
    */
    'view-namespace' => [
        'frontend' => 'app',
        'backend'  => 'app',
    ],

    /*
    |--------------------------------------------------------------------------
    | Hegyd seos controllers package
    |--------------------------------------------------------------------------
    |
    |
    */
    'controllers'    => [
        'backend_namespace'  => 'Hegyd\\Seos\\Controllers\\Backend',
        'frontend_namespace' => 'Frontend\\Content',
    ],

    /*
    |--------------------------------------------------------------------------
    | Hegyd seos routes package
    |--------------------------------------------------------------------------
    |
    |
    */
    'routes'         => [
        'backend'  => [
            'prefix_route'  => 'admin',
            'prefix'        => [
                'seos'          => 'admin.seos.',
                'seo_url_redirects' => 'admin.seo_url_redirects.',
            ],
            'seos'          => [
                'index'         => 'admin.seos.index',
                'create'        => 'admin.seos.create',
                'store'         => 'admin.seos.store',
                'edit'          => 'admin.seos.edit',
                'update'        => 'admin.seos.update',
                'toggle-active' => 'admin.seos.toggle-active',
                'destroy'       => 'admin.seos.destroy',
            ],
            'seo_url_redirects'          => [
                'index'         => 'admin.seo_url_redirects.index',
                'create'        => 'admin.seo_url_redirects.create',
                'store'         => 'admin.seo_url_redirects.store',
                'edit'          => 'admin.seo_url_redirects.edit',
                'update'        => 'admin.seo_url_redirects.update',
                'toggle-active' => 'admin.seo_url_redirects.toggle-active',
                'destroy'       => 'admin.seo_url_redirects.destroy',
            ],
        ],
        'frontend' => [
            'prefix_route'  => 'frontend',
            'prefix'        => [
                'seos'          => 'frontend.seos.',
                'seo_url_redirects'          => 'frontend.seo_url_redirects.',
            ],
            'seo_url_redirects' => [
                'index' => 'seo_url_redirects.index',
                'show'  => 'seo_url_redirects.show',
            ]
        ],
    ],

    'enable_comment' => true,
    

    'permissions' => [
        'prefix'        => [
            'backend'   => [
                'seos'          => 'admin.seos.',
                'seo_url_redirects'          => 'admin.seo_url_redirects.',
            ],
            'frontend'   => [
                'seos'          => 'frontend.seos.',
                'seo_url_redirects'          => 'frontend.seo_url_redirects.',
            ],
        ],
        'backend'   => [
            'seos' => [
                'create' => 'admin.seos.create',
                'edit'   => 'admin.seos.edit',
            ],
            'seo_url_redirects' => [
                'create' => 'admin.seo_url_redirects.create',
                'edit'   => 'admin.seo_url_redirects.edit',
            ],
        ],
        'frontend' => [
            'seos' => [
                'show'      => 'frontend.seos.show',
            ],
            'seo_url_redirects' => [
                'show'      => 'frontend.seo_url_redirects.show',
            ],
        ],
    ],
];