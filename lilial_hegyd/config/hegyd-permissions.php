<?php


return [

    /*
   |--------------------------------------------------------------------------
   | Hegyd Role Model
   |--------------------------------------------------------------------------
   |
   */
    'role_model'       => \Hegyd\Permissions\Models\Role::class,

    /*
   |--------------------------------------------------------------------------
   | Hegyd Permission Model
   |--------------------------------------------------------------------------
   |
   |
   */
    'permission_model' => \Hegyd\Permissions\Models\Permission::class,

    /*
      |--------------------------------------------------------------------------
      | Hegyd Category Permission Model
      |--------------------------------------------------------------------------
      |
      |
      */
    'category_model'   => \Hegyd\Permissions\Models\CategoryPermission::class,
    'category_table'   => 'category_permission',

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
    'main_layout'      => 'layouts.app',

    'routes' => [
        'index'  => 'admin.permissions.index',
        'update' => 'admin.permissions.update',
    ],

    'acl' => [
        'index' => 'admin.acl.index',
        'edit'  => 'admin.acl.edit',
    ],

];