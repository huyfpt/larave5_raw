<?php

Route::group([
    'prefix' => config('hegyd-ecommerce.routes.backend.prefix_route')
], function () {
    /*
     * Backend Category
     */
    Route::group(['namespace' => config('hegyd-ecommerce.controllers.category.backend_namespace'), 'prefix' => 'referentiel/categories'], function () {
        Route::get('/', [
            'as'   => config('hegyd-ecommerce.routes.backend.category.index'),
            'uses' => 'CategoriesController@index',
        ]);

        Route::get('/{id}/edition', [
            'as'   => config('hegyd-ecommerce.routes.backend.category.edit'),
            'uses' => 'CategoriesController@edit',
        ]);

        Route::put('/{id}', [
            'as'   => config('hegyd-ecommerce.routes.backend.category.update'),
            'uses' => 'CategoriesController@update',
        ]);

        Route::get('/creation', [
            'as'   => config('hegyd-ecommerce.routes.backend.category.create'),
            'uses' => 'CategoriesController@create',
        ]);

        Route::post('/modal-creation', [
            'as'   => config('hegyd-ecommerce.routes.backend.category.create-from-modal'),
            'uses' => 'CategoriesController@createFromModal',
        ]);

        Route::post('/', [
            'as'   => config('hegyd-ecommerce.routes.backend.category.store'),
            'uses' => 'CategoriesController@store',
        ]);

        Route::delete('/{id}', [
            'as'   => config('hegyd-ecommerce.routes.backend.category.destroy'),
            'uses' => 'CategoriesController@destroy',
        ]);

        Route::put('{id}/toggle-active', [
            'as'   => config('hegyd-ecommerce.routes.backend.category.toggle-active'),
            'uses' => 'CategoriesController@toggleActive',
        ]);

        Route::get('/json', [
            'as'   => config('hegyd-ecommerce.routes.backend.category.json'),
            'uses' => 'CategoriesController@json',
        ]);

        Route::post('/update-tree', [
            'as'   => config('hegyd-ecommerce.routes.backend.category.update-tree'),
            'uses' => 'CategoriesController@updateTree',
        ]);

        Route::get('/ajax-nestable', [
            'as'   => config('hegyd-ecommerce.routes.backend.category.ajax-nestable'),
            'uses' => 'CategoriesController@ajaxNestable',
        ]);

        Route::post('/update-nestable', [
            'as'   => config('hegyd-ecommerce.routes.backend.category.update-nestable'),
            'uses' => 'CategoriesController@updateNestable',
        ]);

    });

    /*
     * Backend Product
     */
    Route::group(['namespace' => config('hegyd-ecommerce.controllers.product.backend_namespace'), 'prefix' => 'referentiel/produits'], function () {
        Route::get('/', [
            'as'   => config('hegyd-ecommerce.routes.backend.product.index'),
            'uses' => 'ProductsController@index',
        ]);

        Route::get('/{id}/edition', [
            'as'   => config('hegyd-ecommerce.routes.backend.product.edit'),
            'uses' => 'ProductsController@edit',
        ]);

        Route::put('/{id}', [
            'as'   => config('hegyd-ecommerce.routes.backend.product.update'),
            'uses' => 'ProductsController@update',
        ]);

        Route::get('/creation', [
            'as'   => config('hegyd-ecommerce.routes.backend.product.create'),
            'uses' => 'ProductsController@create',
        ]);

        Route::post('/', [
            'as'   => config('hegyd-ecommerce.routes.backend.product.store'),
            'uses' => 'ProductsController@store',
        ]);

        Route::delete('/{id}', [
            'as'   => config('hegyd-ecommerce.routes.backend.product.destroy'),
            'uses' => 'ProductsController@destroy',
        ]);

        Route::put('{id}/toggle-active', [
            'as'   => config('hegyd-ecommerce.routes.backend.product.toggle-active'),
            'uses' => 'ProductsController@toggleActive',
        ]);


        Route::post('{id}/uploads', [
            'as'   => config('hegyd-ecommerce.routes.backend.product.uploads.store'),
            'uses' => 'ProductsController@storeUpload',
        ]);

        Route::put('{id}/uploads', [
            'as'   => config('hegyd-ecommerce.routes.backend.product.uploads.update'),
            'uses' => 'ProductsController@updateUploads',
        ]);

        Route::post('{product_id}/uploads/{visual_id}/delete', [
            'as'   => config('hegyd-ecommerce.routes.backend.product.uploads.delete'),
            'uses' => 'ProductsController@deleteUpload',
        ]);

        Route::get('/product-related', [
            'as'   => config('hegyd-ecommerce.routes.backend.product.product-related'),
            'uses' => 'ProductsController@ajaxProductRelated',
        ]);

        Route::get('/brand-logo', [
            'as'   => config('hegyd-ecommerce.routes.backend.product.brand-logo'),
            'uses' => 'ProductsController@ajaxBrandLogo',
        ]);

        Route::get('/export', [
            'as'   => config('hegyd-ecommerce.routes.backend.product.excel'),
            'uses' => 'ProductsController@exportExcel',
        ]);

        Route::post('/import-zip', [
            'as'   => config('hegyd-ecommerce.routes.backend.product.import-zip'),
            'uses' => 'ProductsController@importZip',
        ]);
    });


    /*
     * Backend Order
     */
    Route::group(['namespace' => config('hegyd-ecommerce.controllers.order.backend_namespace'), 'prefix' => 'commandes'], function () {
        Route::get('/', [
            'as'   => config('hegyd-ecommerce.routes.backend.order.index'),
            'uses' => 'OrdersController@index',
        ]);

        Route::get('/archivees', [
            'as'   => config('hegyd-ecommerce.routes.backend.order.archived'),
            'uses' => 'OrdersController@archived',
        ]);

        Route::get('/{id}/edition', [
            'as'   => config('hegyd-ecommerce.routes.backend.order.edit'),
            'uses' => 'OrdersController@edit',
        ]);

        Route::put('/{id}', [
            'as'   => config('hegyd-ecommerce.routes.backend.order.update'),
            'uses' => 'OrdersController@update',
        ]);

        Route::delete('/{id}', [
            'as'   => config('hegyd-ecommerce.routes.backend.order.destroy'),
            'uses' => 'OrdersController@destroy',
        ]);

        Route::get('/{id}/telecharger-facture', [
            'as'   => config('hegyd-ecommerce.routes.backend.order.download-invoice'),
            'uses' => 'OrdersController@downloadInvoice',
        ]);
    });

});

Route::group(['namespace' => config('hegyd-ecommerce.controllers.product.frontend_namespace')], function () {
    Route::get('/produits', [
        'as'   => config('hegyd-ecommerce.routes.frontend.product.index'),
        'uses' => 'ProductsController@index',
    ]);

    Route::get('/produits/category/{slug}', [
        'as'   => config('hegyd-ecommerce.routes.frontend.product.category'),
        'uses' => 'ProductsController@category',
    ])->where(['slug' => '(.*)', 'id' => '[0-9]+']);

    Route::post('/produits/search', [
        'as'   => config('hegyd-ecommerce.routes.frontend.product.search'),
        'uses' => 'ProductsController@search',
    ]);

    Route::get('/produits/suggest', [
        'as'   => config('hegyd-ecommerce.routes.frontend.product.suggest'),
        'uses' => 'ProductsController@suggest',
    ]);

    Route::get('/produits/{slug}', [
        'as'   => config('hegyd-ecommerce.routes.frontend.product.show'),
        'uses' => 'ProductsController@show',
    ])->where(['slug' => '(.*)', 'id' => '[0-9]+']);


});
Route::group([
    'namespace' => config('hegyd-ecommerce.controllers.cart.frontend_namespace'),
    'prefix'    => 'mon-panier',
], function () {

    Route::get('/', [
        'as'   => config('hegyd-ecommerce.routes.frontend.cart.index'),
        'uses' => 'CartController@index',
    ]);

    Route::post('/ajout', [
        'as'   => config('hegyd-ecommerce.routes.frontend.cart.add'),
        'uses' => 'CartController@add',
    ]);

    Route::delete('/suppression', [
        'as'   => config('hegyd-ecommerce.routes.frontend.cart.remove'),
        'uses' => 'CartController@remove',
    ]);

    Route::put('/mise-a-jour', [
        'as'   => config('hegyd-ecommerce.routes.frontend.cart.update'),
        'uses' => 'CartController@update',
    ]);

    Route::put('/remise-a-zero', [
        'as'   => config('hegyd-ecommerce.routes.frontend.cart.reset'),
        'uses' => 'CartController@reset',
    ]);

    Route::post('/paiement', [
        'as'   => config('hegyd-ecommerce.routes.frontend.cart.payment'),
        'uses' => 'CartController@payment',
    ]);

    Route::get('/paiement-succes', [
        'as'   => config('hegyd-ecommerce.routes.frontend.cart.payment-success'),
        'uses' => 'CartController@paymentSuccess',
    ]);

    Route::get('/paiement-echoue', [
        'as'   => config('hegyd-ecommerce.routes.frontend.cart.payment-failed'),
        'uses' => 'CartController@paymentFailed',
    ]);

    Route::get('/popup', [
        'uses' => 'CartController@popup',
        'as'   => config('hegyd-ecommerce.routes.frontend.cart.popup'),
    ]);

    Route::group(['prefix' => 'adresses'], function () {
        Route::get('/choix', [
            'uses' => 'CartController@addressList',
            'as'   => config('hegyd-ecommerce.routes.frontend.cart.address.list'),
        ]);

        Route::post('/choix', [
            'uses' => 'CartController@addressChoosed',
            'as'   => config('hegyd-ecommerce.routes.frontend.cart.address.choosed'),
        ]);

        Route::get('/ajout', [
            'uses' => 'CartController@addressAdd',
            'as'   => config('hegyd-ecommerce.routes.frontend.cart.address.add'),
        ]);

        Route::post('/ajout', [
            'uses' => 'CartController@addressStore',
            'as'   => config('hegyd-ecommerce.routes.frontend.cart.address.store'),
        ]);

        Route::get('{id}/mise-a-jour', [
            'uses' => 'CartController@addressEdit',
            'as'   => config('hegyd-ecommerce.routes.frontend.cart.address.edit'),
        ]);

        Route::put('{id}/mise-a-jour', [
            'uses' => 'CartController@addressUpdate',
            'as'   => config('hegyd-ecommerce.routes.frontend.cart.address.update'),
        ]);
    });
});


Route::group([
    'namespace' => config('hegyd-ecommerce.controllers.order.frontend_namespace'),
    'prefix'    => 'mes-commandes',
], function () {
    Route::get('/', [
        'uses' => 'OrdersController@index',
        'as'   => config('hegyd-ecommerce.routes.frontend.order.index'),
    ]);
    Route::get('/{id}', [
        'uses' => 'OrdersController@show',
        'as'   => config('hegyd-ecommerce.routes.frontend.order.show'),
    ]);
    Route::get('/{id}/telecharger-facture', [
        'uses' => 'OrdersController@downloadInvoice',
        'as'   => config('hegyd-ecommerce.routes.frontend.order.download-invoice'),
    ]);
    Route::get('/{id}/re-commander', [
        'uses' => 'OrdersController@reOrder',
        'as'   => config('hegyd-ecommerce.routes.frontend.order.re-order'),
    ]);
});