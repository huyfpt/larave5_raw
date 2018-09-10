<?php


return [

    /*
   |--------------------------------------------------------------------------
   | Hegyd Role Model
   |--------------------------------------------------------------------------
   |
   */
    'role_model'       => 'Hegyd\Permissions\Models\Role',

    /*
   |--------------------------------------------------------------------------
   | Hegyd Permission Model
   |--------------------------------------------------------------------------
   |
   |
   */
    'permission_model' => 'Hegyd\Permissions\Models\Permission',

    /*
      |--------------------------------------------------------------------------
      | Hegyd Category Permission Model
      |--------------------------------------------------------------------------
      |
      |
      */
    'category_model'   => 'Hegyd\Permissions\Models\CategoryPermission',
    'category_table'   => 'permission_categories',

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
    'main_layout'      => 'app',

    'routes' => [
        'index'  => 'permissions.index',
        'update' => 'permissions.update',
    ],

    'acl' => [
        'index' => 'admin.acl.index',
        'edit'  => 'admin.acl.edit',
    ],
];