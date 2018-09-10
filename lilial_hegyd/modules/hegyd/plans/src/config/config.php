<?php

return [

    /*
   |--------------------------------------------------------------------------
   | Hegyd Plans Model
   |--------------------------------------------------------------------------
   |
   | This is the Plans model used to create correct relations.  Update
   | the plans if it is in a different namespace.
   |
   */
    'models'         => [
        'plans'                 => \Hegyd\Plans\Models\Plans::class,
        'plans_category'        => \Hegyd\Plans\Models\PlansCategory::class,
        'role'                  => \Hegyd\Permissions\Models\Role::class,
        'user'                  => \App\Models\Common\User::class,
        'city'                  => \App\Models\Common\City::class,
    ],
    
    'services'  => [
        'extranet'   => 'App\Services\Common\ExtranetService',
        'plans'      => \Hegyd\Plans\Services\PlansService::class,
        'mail'       => \Hegyd\Plans\Services\MailService::class,
    ],

    'filters' => [
        'plans' => Hegyd\Plans\Repositories\Filters\FilterPlans::class,
    ],
    'administrators' => [
        'super_admin',
        'admin'
    ],

    'repository' => [
        'plans' => \Hegyd\Plans\Repositories\Contracts\PlansRepositoryInterface::class,
        'users' => \App\Repositories\Contracts\Common\UserRepositoryInterface::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Hegyd Plans Table
    |--------------------------------------------------------------------------
    |
    | This is the plans table used to save plans to the database.
    |
    */
    'tables'         => [
        'plans'          => 'plans',
        'plans_category' => 'plans_categories',
        'role'          => 'roles',
    ],

    /*
    |--------------------------------------------------------------------------
    | Hegyd Plans main layout
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
        'email'    => 'email',
    ],
    /*
    |--------------------------------------------------------------------------
    | Hegyd Plans view namespace
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
    | Hegyd Plans controllers package
    |--------------------------------------------------------------------------
    |
    |
    */
    'controllers'    => [
        'backend_namespace'  => 'Hegyd\\Plans\\Controllers\\Backend',
        'frontend_namespace' => 'Hegyd\\Plans\\Controllers\\Frontend',
    ],

    /*
    |--------------------------------------------------------------------------
    | Hegyd Plans routes package
    |--------------------------------------------------------------------------
    |
    |
    */
    'routes'         => [
        'backend'  => [
            'prefix_route'  => 'admin',
            'prefix'        => [
                'plans_category' => 'admin.plans_category.',
                'plans'          => 'admin.plans.',
            ],
            'plans'          => [
                'index'         => 'admin.plans.index',
                'create'        => 'admin.plans.create',
                'store'         => 'admin.plans.store',
                'edit'          => 'admin.plans.edit',
                'update'        => 'admin.plans.update',
                'toggle-active' => 'admin.plans.toggle-active',
                'destroy'       => 'admin.plans.destroy',
            ],
            'plans_category' => [
                'index'             => 'admin.plans_category.index',
                'create'            => 'admin.plans_category.create',
                'create-from-modal' => 'admin.plans_category.create-from-modal',
                'store'             => 'admin.plans_category.store',
                'edit'              => 'admin.plans_category.edit',
                'update'            => 'admin.plans_category.update',
                'toggle-active'     => 'admin.plans_category.toggle-active',
                'destroy'           => 'admin.plans_category.destroy',
            ],
        ],
        'frontend' => [
            'prefix_route'  => 'club',
            'prefix'        => [
                'plans_category' => 'frontend.plans_category.',
                'plans'          => 'frontend.plans.',
            ],
            'plans' => [
                'index' => 'plans.index'
            ],
            'plans_category' => [
                'index' => 'plans_category.index',
                'show'  => 'plans_category.show',
            ]
        ],
    ],

    'enable_comment' => true,
    

    'permissions' => [
        'prefix'        => [
            'backend'   => [
                'plans_category' => 'admin.plans_category.',
                'plans'          => 'admin.plans.',
                'report_comment'=> 'admin.report_comment.',
            ],
            'frontend'   => [
                'plans_category' => 'frontend.plans_category.',
                'plans'          => 'frontend.plans.',
            ],
        ],
        'backend'   => [
            'plans_category' => [
                'create' => 'admin.plans_category.create',
                'edit'   => 'admin.plans_category.edit',
            ],
            'plans' => [
                'create' => 'admin.plans.create',
                'edit'   => 'admin.plans.edit',
            ],
        ],
        'frontend' => [
            'plans_category' => [
                'index'     => 'frontend.plans.index',
            ],
            'plans' => [
                'show'      => 'frontend.plans.show',
                'comments' => [
                    'create' => 'extranet.plans.comments.create',
                    'edit'   => 'extranet.plans.comments.edit',
                    'delete' => 'extranet.plans.comments.delete',
                    'report' => 'extranet.plans.comments.report',
                ],
            ],
        ],
    ],
];