<?php

return [

    /*
   |--------------------------------------------------------------------------
   | Hegyd Faqs Model
   |--------------------------------------------------------------------------
   |
   | This is the Faqs model used to create correct relations.  Update
   | the faqs if it is in a different namespace.
   |
   */
    'models'         => [
        'faqs'                  => \Hegyd\Faqs\Models\Faqs::class,
        'faqs_category'         => \Hegyd\Faqs\Models\FaqsCategory::class,
        'newsletters'           => \Hegyd\Faqs\Models\Newsletter::class,
        'role'                  => \Hegyd\Permissions\Models\Role::class,
        'user'                  => \App\Models\Common\User::class,
    ],
    
    'services'  => [
        'extranet'   => 'App\Services\Common\ExtranetService',
        'faqs'       => \Hegyd\Faqs\Services\FaqsService::class,
        'mail'       => \Hegyd\Faqs\Services\MailService::class,
    ],

    'filters' => [
        'faqs' => Hegyd\Faqs\Repositories\Filters\FilterFaqs::class,
    ],
    'administrators' => [
        'super_admin',
        'admin'
    ],

    'repository' => [
        'faqs' => \Hegyd\Faqs\Repositories\Contracts\FaqsRepositoryInterface::class,
        'users' => \App\Repositories\Contracts\Common\UserRepositoryInterface::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Hegyd Faqs Table
    |--------------------------------------------------------------------------
    |
    | This is the faqs table used to save faqs to the database.
    |
    */
    'tables'         => [
        'faqs'          => 'faqs',
        'faqs_category' => 'faqs_categories',
        'role'          => 'roles',
        'newsletters'          => 'newsletters',
    ],

    /*
    |--------------------------------------------------------------------------
    | Hegyd Faqs main layout
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
    | Hegyd Faqs view namespace
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
    | Hegyd Faqs controllers package
    |--------------------------------------------------------------------------
    |
    |
    */
    'controllers'    => [
        'backend_namespace'  => 'Admin\\Content',
        'frontend_namespace' => 'Frontend\\Content',
    ],

    /*
    |--------------------------------------------------------------------------
    | Hegyd Faqs routes package
    |--------------------------------------------------------------------------
    |
    |
    */
    'routes'         => [
        'backend'  => [
            'prefix_route'  => 'admin',
            'prefix'        => [
                'faqs_category' => 'admin.faqs_category.',
                'faqs'          => 'admin.faqs.',
                'newsletters'    => 'admin.newsletters.',
            ],
            'faqs'          => [
                'index'         => 'admin.faqs.index',
                'create'        => 'admin.faqs.create',
                'store'         => 'admin.faqs.store',
                'edit'          => 'admin.faqs.edit',
                'update'        => 'admin.faqs.update',
                'toggle-active' => 'admin.faqs.toggle-active',
                'destroy'       => 'admin.faqs.destroy',
            ],
            'faqs_category' => [
                'index'             => 'admin.faqs_category.index',
                'create'            => 'admin.faqs_category.create',
                'create-from-modal' => 'admin.faqs_category.create-from-modal',
                'store'             => 'admin.faqs_category.store',
                'edit'              => 'admin.faqs_category.edit',
                'update'            => 'admin.faqs_category.update',
                'toggle-active'     => 'admin.faqs_category.toggle-active',
                'destroy'           => 'admin.faqs_category.destroy',
            ],
            'newsletters' => [
                'index'         => 'admin.newsletters.index',
                'create'        => 'admin.newsletters.create',
                'edit'          => 'admin.newsletters.edit',
                'update'        => 'admin.newsletters.update',
                'destroy'       => 'admin.newsletters.destroy',
                'toggle-active' => 'admin.newsletters.toggle-active',
                'export-csv'    => 'admin.newsletters.export-csv',
                'export-excel'    => 'admin.newsletters.export-excel'
            ],
            
        ],
        'frontend' => [
            'prefix_route'  => 'frontend',
            'prefix'        => [
                'faqs_category' => 'frontend.faqs_category.',
                'faqs'          => 'frontend.faqs.',
                // 'comments'      => 'frontend.comments.',
            ],
            'faqs_category' => [
                'index' => 'faqs_category.index',
                'show_list'  => 'faqs_category.showList',
            ],
            'faqs'          => [
                'index' => 'faqs.index',
                'show' => 'faqs.show',
                // 'like' => 'faqs.like',
            ],
            'newsletters' => [
                'create-from-modal' => 'frontend.newsletters.store',
                'create-from-form'  => 'frontend.newsletters.ajaxSave'
            ],
            // 'comments' => [
            //     'edit-from-modal'   => 'frontend.comments.edit-from-modal',
            //     'update-from-modal' => 'frontend.comments.update-from-modal',
            //     'destroy'           => 'frontend.comments.destroy',
            //     'create-from-modal' => 'frontend.comments.create-from-modal',
            //     'save-from-modal'   => 'frontend.comments.save-from-modal',
            //     'get-report'        => 'frontend.comments.get-report',
            //     'report'            => 'frontend.comments.report',
            // ]
        ],
    ],

    'enable_comment' => true,
    

    'permissions' => [
        'prefix'        => [
            'backend'   => [
                'faqs_category' => 'admin.faqs_category.',
                'faqs'          => 'admin.faqs.',
                'newsletters'=> 'admin.newsletters.',
            ],
            'frontend'   => [
                'faqs_category' => 'frontend.faqs_category.',
                'faqs'          => 'frontend.faqs.',
            ],
        ],
        'backend'   => [
            'faqs_category' => [
                'create' => 'admin.faqs_category.create',
                'edit'   => 'admin.faqs_category.edit',
            ],
            'faqs' => [
                'create' => 'admin.faqs.create',
                'edit'   => 'admin.faqs.edit',
            ],
            'newsletters' => [
                'show' => 'admin.newsletters.show',
                'edit' => 'admin.newsletters.edit',
            ],
        ],
        'frontend' => [
            'faqs_category' => [
                'index'     => 'frontend.faqs.index',
                'show'      => 'frontend.faqs_category.show'
            ],
            'faqs' => [
                'show'      => 'frontend.faqs.show',
                'comments' => [
                    'create' => 'extranet.faqs.comments.create',
                    'edit'   => 'extranet.faqs.comments.edit',
                    'delete' => 'extranet.faqs.comments.delete',
                    'report' => 'extranet.faqs.comments.report',
                ],
            ],
        ],
    ],
];