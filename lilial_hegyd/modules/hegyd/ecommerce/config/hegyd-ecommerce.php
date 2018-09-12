<?php

return [

    /*
   |--------------------------------------------------------------------------
   | Hegyd eCommerce Model
   |--------------------------------------------------------------------------
   |
   | This is the eCommerce model used to create correct relations.  Update
   | the news if it is in a different namespace.
   |
   */
    'models' => [
        'product'           => \Hegyd\eCommerce\Models\ProductCatalog\Product::class,
        'product_related'   => \Hegyd\eCommerce\Models\ProductCatalog\ProductRelated::class,
        'product_faq'       => \Hegyd\eCommerce\Models\ProductCatalog\ProductFaq::class,
        'attribute'         => \Hegyd\eCommerce\Models\ProductCatalog\Attribute::class,
        'attribute_option'  => \Hegyd\eCommerce\Models\ProductCatalog\AttributeOption::class,
        'product_attribute' => \Hegyd\eCommerce\Models\ProductCatalog\ProductAttribute::class,
        'feature'           => \Hegyd\eCommerce\Models\ProductCatalog\Feature::class,
        'feature_option'    => \Hegyd\eCommerce\Models\ProductCatalog\FeatureOption::class,
        'product_feature'   => \Hegyd\eCommerce\Models\ProductCatalog\ProductFeature::class,
        'brand'             => \Hegyd\eCommerce\Models\ProductCatalog\Brand::class,
        'category'          => \Hegyd\eCommerce\Models\ProductCatalog\Category::class,
        'cart'              => \Hegyd\eCommerce\Models\eCommerce\Cart::class,
        'cart_line'         => \Hegyd\eCommerce\Models\eCommerce\CartLine::class,
        'order'             => \Hegyd\eCommerce\Models\eCommerce\Order::class,
        'order_line'        => \Hegyd\eCommerce\Models\eCommerce\OrderLine::class,
        'order_history'     => \Hegyd\eCommerce\Models\eCommerce\OrderHistory::class,
        'vat'               => \Hegyd\eCommerce\Models\eCommerce\Vat::class,
        'user'              => 'App\User',
        'address'           => 'App\Address',
        'upload'            => \Hegyd\Uploads\Models\Upload::class,
        'faqs'              => \Hegyd\Faqs\Models\Faqs::class,
    ],

    'repositories' => [
        'address' => 'App\Repositories\AddressRepository',
        'user'    => 'App\Repositories\UserRepository',
    ],

    'services'       => [
        'setting' => 'App\Services\SettingService',
    ],
    /*
    |--------------------------------------------------------------------------
    | Hegyd eCommerce Table
    |--------------------------------------------------------------------------
    |
    | This is the news table used to save news to the database.
    |
    */
    'tables'         => [
        'product'                  => 'products',
        'category'                 => 'product_categories',
        'product_related'          => 'product_related',
        'product_faq'              => 'product_faqs',
        'product_brand'            => 'product_brands',
        'product_attribute'        => 'product_attributes',
        'product_attribute_option' => 'product_attribute_options',
        'product_attributable'     => 'product_attributables',
        'product_feature'          => 'product_features',
        'product_feature_option'   => 'product_feature_options',
        'product_feature_value'    => 'product_feature_values',
        'order'                    => 'orders',
        'order_line'               => 'order_lines',
        'order_history'            => 'order_histories',
        'cart'                     => 'carts',
        'cart_line'                => 'cart_lines',
        'vat'                      => 'vat',
        'address'                  => 'addresses',
        'user'                     => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Hegyd eCommerce main layout
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
        'email'    => 'email',
    ],

    /*
    |--------------------------------------------------------------------------
    | Hegyd eCommerce view namespace
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
    | Hegyd eCommerce controllers package
    |--------------------------------------------------------------------------
    |
    |
    */
    'controllers'    => [
        'category' => [
            'backend_namespace'  => '\\Hegyd\\eCommerce\\Http\\Controllers\\Backend\\ProductCatalog',
            'frontend_namespace' => '\\Hegyd\\eCommerce\\Http\\Controllers\\Frontend\\ProductCatalog',
        ],
        'product'  => [
            'backend_namespace'  => '\\Hegyd\\eCommerce\\Http\\Controllers\\Backend\\ProductCatalog',
            'frontend_namespace' => '\\Hegyd\\eCommerce\\Http\\Controllers\\Frontend\\ProductCatalog',
        ],
        'order'    => [
            'backend_namespace'  => '\\Hegyd\\eCommerce\\Http\\Controllers\\Backend\\eCommerce',
            'frontend_namespace' => '\\Hegyd\\eCommerce\\Http\\Controllers\\Frontend\\eCommerce',
        ],
        'cart'     => [
            'frontend_namespace' => '\\Hegyd\\eCommerce\\Http\\Controllers\\Frontend\\eCommerce',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Hegyd eCommerce routes package
    |--------------------------------------------------------------------------
    |
    |
    */
    'routes'         => [
        'backend'  => [
            'prefix_route' => 'admin',
            'prefix'       => [
                'product'       => 'admin.products.',
                'category'      => 'admin.categories.',
                'order'         => 'admin.orders.',
                'order_line'    => 'admin.order_lines.',
                'order_history' => 'admin.order_histories.',
                'cart'          => 'admin.carts.',
                'cart_line'     => 'admin.cart_lines.',
            ],
            'product'      => [
                'index'         => 'admin.products.index',
                'create'        => 'admin.products.create',
                'store'         => 'admin.products.store',
                'edit'          => 'admin.products.edit',
                'update'        => 'admin.products.update',
                'toggle-active' => 'admin.products.toggle-active',
                'destroy'       => 'admin.products.destroy',
                'uploads'       => [
                    'store'  => 'admin.products.uploads.store',
                    'update' => 'admin.products.uploads.update',
                    'delete' => 'admin.products.uploads.delete',
                ],
                'product-related' => 'admin.products.product-related',
                'brand-logo'      => 'admin.products.brand-logo',
                'excel'           => 'admin.products.export.excel',
                'import-zip'    => 'admin.products.import.zip',
            ],
            'category'     => [
                'index'             => 'admin.categories.index',
                'create'            => 'admin.categories.create',
                'create-from-modal' => 'admin.categories.create-from-modal',
                'store'             => 'admin.categories.store',
                'edit'              => 'admin.categories.edit',
                'update'            => 'admin.categories.update',
                'toggle-active'     => 'admin.categories.toggle-active',
                'destroy'           => 'admin.categories.destroy',
                'json'              => 'admin.categories.json',
                'update-tree'       => 'admin.categories.update-tree',
                'ajax-nestable'     => 'admin.categories.ajax-nestable',
                'update-nestable'   => 'admin.categories.update-nestable',
            ],
            'order'        => [
                'index'            => 'admin.orders.index',
                'archived'         => 'admin.orders.archived',
                'create'           => 'admin.orders.create',
                'store'            => 'admin.orders.store',
                'edit'             => 'admin.orders.edit',
                'update'           => 'admin.orders.update',
                'destroy'          => 'admin.orders.destroy',
                'download-invoice' => 'admin.orders.download-invoice',
            ],
            'user'         => [
                'edit' => 'admin.users.edit',
            ]
        ],
        'frontend' => [
            'prefix_route' => 'frontend',
            'prefix'       => [
                'product' => 'frontend.products.',
                'order'   => 'frontend.orders.',
                'cart'    => 'frontend.cart.',
            ],
            'product'      => [
                'index'      => 'frontend.products.index',
                'search'     => 'frontend.products.search',
                'category'   => 'frontend.products.category',
                'show'       => 'frontend.products.show',
                'suggest'    => 'frontend.products.suggest',
            ],
            'order'        => [
                'index'            => 'frontend.orders.index',
                'show'             => 'frontend.orders.show',
                're-order'         => 'frontend.orders.re-order',
                'download-invoice' => 'frontend.orders.download-invoice',
            ],
            'cart'         => [
                'index'           => 'frontend.cart.index',
                'update'          => 'frontend.cart.update',
                'reset'           => 'frontend.cart.reset',
                'add'             => 'frontend.cart.add',
                'remove'          => 'frontend.cart.remove',
                'popup'           => 'frontend.cart.popup',
                'payment'         => 'frontend.cart.payment',
                'payment-success' => 'frontend.cart.payment-success',
                'payment-failed'  => 'frontend.cart.payment-failed',
                'address'         => [
                    'add'     => 'frontend.cart.addresses.add',
                    'store'   => 'frontend.cart.addresses.store',
                    'edit'    => 'frontend.cart.addresses.edit',
                    'update'  => 'frontend.cart.addresses.update',
                    'list'    => 'frontend.cart.addresses.list',
                    'choosed' => 'frontend.cart.addresses.choosed',
                ],
            ],
        ],
    ],

    'permissions' => [
        'prefix'  => [
            'backend'  => [
                'category' => 'admin.categories.',
                'product'  => 'admin.products.',
                'order'    => 'admin.orders.',
            ],
            'frontend' => [
                'ecommerce' => 'extranet.ecommerce.',
            ],
        ],
        'backend' => [
            'category' => [
                'create' => 'admin.categories.create',
                'edit'   => 'admin.categories.edit',
                'delete' => 'admin.categories.delete',
            ],
            'product'  => [
                'create' => 'admin.products.create',
                'edit'   => 'admin.products.edit',
                'delete' => 'admin.products.delete',
            ],
            'order'    => [
                'edit' => 'admin.orders.edit',
            ],
        ],

        'frontend' => [
            'ecommerce' => [
                'index' => 'extranet.ecommerce.index',
            ],
        ],
    ],
    'cart'        => [
        'minimum_price' => env('HEGYD_ECOMMERCE_CART_MINIMUM_PRICE', 0),
    ],

    'payments' => [
        'paypal' => [
            'provider' => \Hegyd\eCommerce\Services\eCommerce\Payment\PaypalProvider::class,
            'active'   => env('HEGYD_ECOMMERCE_PAYMENT_PAYPAL_ACTIVE', true),
            'username' => env('HEGYD_ECOMMERCE_PAYMENT_PAYPAL_USERNAME'),
            'password' => env('HEGYD_ECOMMERCE_PAYMENT_PAYPAL_PASSWORD'),
            'settings' => [
                'mode' => env('HEGYD_ECOMMERCE_PAYMENT_PAYPAL_MODE', 'sandbox'), // sandbox or live
                'logs' => [
                    'enable'   => env('HEGYD_ECOMMERCE_PAYMENT_PAYPAL_LOG_ENABLE', true),
                    'level'    => env('HEGYD_ECOMMERCE_PAYMENT_PAYPAL_LOG_LEVEL', 'FINE'),
                    'filepath' => env('HEGYD_ECOMMERCE_PAYMENT_PAYPAL_LOG_FILENAME', storage_path('/logs/paypal.log')),
                ],
            ],
        ],
    ],

    'meta_robots' => [
        'INDEX, FOLLOW'     => 'INDEX, FOLLOW',
        'NOINDEX, FOLLOW'   => 'NOINDEX, FOLLOW',
        'INDEX, NOFOLLOW'   => 'INDEX, NOFOLLOW',
        'NOINDEX, NOFOLLOW' => 'NOINDEX, NOFOLLOW'
    ],
];