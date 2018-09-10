<?php
Route::group(['as' => 'eav.', 'namespace' => 'EAV', 'prefix' => 'attributs'],

    function ()
    {

        /* Affichage */
        Route::get('/', [
            'as'   => 'index',
            'uses' => 'AttributesController@index',
        ]);

        /* Création */
        Route::get('/valeurs/creation', [
            'as'   => 'create',
            'uses' => 'AttributeValuesController@create',
        ]);

        Route::post('/valeurs/creation', [
            'as'   => 'store',
            'uses' => 'AttributeValuesController@store',
        ]);

        /* Edition */
        Route::get('/valeurs/{id}/edition', [
            'as'   => 'edit',
            'uses' => 'AttributeValuesController@edit',
        ]);

        Route::put('/valeurs/{id}', [
            'as'   => 'update',
            'uses' => 'AttributeValuesController@update',
        ]);

        /* Suppression */
        Route::delete('/valeurs/{id}', [
            'as'   => 'destroy',
            'uses' => 'AttributeValuesController@destroy',
        ]);

        // Déplacement
        Route::post('/valeurs/deplacer', [
            'as'   => 'move',
            'uses' => 'AttributeValuesController@move',
        ]);

    }

);