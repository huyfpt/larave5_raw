<?php

return [

    /*
   |--------------------------------------------------------------------------
   | Hegyd News Model
   |--------------------------------------------------------------------------
   |
   | This is the News model used to create correct relations.  Update
   | the news if it is in a different namespace.
   |
   */
    'models' => [
        'news'                => App\Models\Common\News::class,
        'news_category'       => App\Models\Common\NewsCategory::class,
        'user'                => \App\Models\Common\User::class,
        'news_like'           => \Hegyd\News\Models\NewsLike::class,
        'news_comment'        => \Hegyd\News\Models\NewsComment::class,
        'news_report_comment' => \Hegyd\News\Models\ReportComment::class,
    ],

    'services' => [
        'extranet' => 'App\Services\Common\ExtranetService',
        'news'     => \Hegyd\News\Services\NewsService::class,
        'mail'     => \Hegyd\News\Services\MailService::class,
    ],

    'filters'        => [
        'news' => App\Repositories\Filters\FilterNews::class,
    ],
    'administrators' => [
        'super_admin',
        'admin'
    ],

    'repository'     => [
        'news'  => \Hegyd\News\Repositories\Contracts\NewsRepositoryInterface::class,
        'users' => \App\Repositories\Contracts\Common\UserRepositoryInterface::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Hegyd News Table
    |--------------------------------------------------------------------------
    |
    | This is the news table used to save news to the database.
    |
    */
    'tables'         => [
        'news'                 => 'news',
        'news_category'        => 'news_categories',
        'role'                 => 'news_role',
        'comments'             => 'news_comments',
        'likes'                => 'news_likes',
        'news_comments_report' => 'news_comments_report',
        'users'                => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Hegyd News main layout
    |--------------------------------------------------------------------------
    |
    | This is the main layout where is display the views.
    | Ex :
    |   @extends('main_layout')
    |
    */
    'main_layout'    => [
        'frontend' => 'layouts.app',
        'backend'  => 'layouts.app',
    ],

    /*
    |--------------------------------------------------------------------------
    | Hegyd News view namespace
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
    | Hegyd News controllers package
    |--------------------------------------------------------------------------
    |
    |
    */
    'controllers'    => [
        'backend_namespace'  => 'Admin\\Content',
        'frontend_namespace' => 'Extranet\\Content',
    ],

    /*
    |--------------------------------------------------------------------------
    | Hegyd News routes package
    |--------------------------------------------------------------------------
    |
    |
    */
    'routes'         => [
        'backend'  => [
            'prefix_route'   => 'admin',
            'prefix'         => [
                'news_category'  => 'admin.news_category.',
                'news'           => 'admin.news.',
                'report_comment' => 'admin.report_comment.',
            ],
            'news'           => [
                'index'         => 'admin.news.index',
                'create'        => 'admin.news.create',
                'store'         => 'admin.news.store',
                'edit'          => 'admin.news.edit',
                'update'        => 'admin.news.update',
                'toggle-active' => 'admin.news.toggle-active',
                'destroy'       => 'admin.news.destroy',
            ],
            'news_category'  => [
                'index'             => 'admin.news_category.index',
                'create'            => 'admin.news_category.create',
                'create-from-modal' => 'admin.news_category.create-from-modal',
                'store'             => 'admin.news_category.store',
                'edit'              => 'admin.news_category.edit',
                'update'            => 'admin.news_category.update',
                'toggle-active'     => 'admin.news_category.toggle-active',
                'destroy'           => 'admin.news_category.destroy',
            ],
            'users' => [
                'edit'      => 'admin.users.edit',
            ],
            'report_comment' => [
                'index'          => 'admin.report_comment.index',
                'edit'           => 'admin.report_comment.edit',
                'update'         => 'admin.report_comment.update',
                'destroy'        => 'admin.report_comment.destroy',
                'get_send_mail'  => 'admin.report_comment.get-send-mail',
                'post_send_mail' => 'admin.report_comment.post-send-mail',
            ],
            'comments'       => [
                'destroy' => 'admin.comments.destroy',
            ],
        ],
        'frontend' => [
            'prefix_route'  => 'extranet',
            'prefix'        => [
                'news_category' => 'extranet.news_category.',
                'news'          => 'extranet.news.',
                'comments'      => 'extranet.comments.',
            ],
            'news_category' => [
                'index' => 'news_category.index',
                'show'  => 'news_category.show',
            ],
            'news'          => [
                'show' => 'news.show',
                'like' => 'news.like',
            ],
            'comments'      => [
                'edit-from-modal'   => 'extranet.comments.edit-from-modal',
                'update-from-modal' => 'extranet.comments.update-from-modal',
                'destroy'           => 'extranet.comments.destroy',
                'create-from-modal' => 'extranet.comments.create-from-modal',
                'save-from-modal'   => 'extranet.comments.save-from-modal',
                'get-report'        => 'extranet.comments.get-report',
                'report'            => 'extranet.comments.report',
            ]
        ],
    ],

    'enable_comment' => true,


    'permissions' => [
        'prefix'   => [
            'backend'  => [
                'news_category'  => 'admin.news.category.',
                'news'           => 'admin.news.',
                'report_comment' => 'admin.news.report_comment.',
            ],
            'frontend' => [
                'news_category' => 'extranet.news.',
                'news'          => 'extranet.news.',
            ],
        ],
        'backend'  => [
            'news_category'  => [
                'create' => 'admin.news.category.create',
                'edit'   => 'admin.news.category.edit',
            ],
            'news'           => [
                'create' => 'admin.news.create',
                'edit'   => 'admin.news.edit',
            ],
            'report_comment' => [
                'show' => 'admin.news.report_comment.show',
                'edit' => 'admin.news.report_comment.edit',
            ],
        ],
        'frontend' => [
            'news_category' => [
                'index' => 'extranet.news.index',
            ],
            'news'          => [
                'show'     => 'extranet.news.index',
                'comments' => [
                    'create' => 'extranet.news.comments.create',
                    'edit'   => 'extranet.news.comments.edit',
                    'delete' => 'extranet.news.comments.delete',
                    'report' => 'extranet.news.comments.report',
                ],
            ],
        ],
    ],
];