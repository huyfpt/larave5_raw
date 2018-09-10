<?php

Route::get('admin/mon_profil', [
    'as'   => 'users.my_profile',
    'uses' => 'Common\UsersController@myProfile',
]);

Route::put('admin/mon_profil', [
    'as'   => 'users.my_profile.update',
    'uses' => 'Common\UsersController@myProfileUpdate',
]);

Route::get('admin/utilisateurs/recherche', [
    'as'   => 'users.search',
    'uses' => 'Common\UsersController@search',
]);

Route::get('admin/utilisateurs/{id}', [
    'as'   => 'users.show',
    'uses' => 'Common\UsersController@show',
]);

Route::get('admin/utilisateurs/show-modal/{id}', [
    'as'   => 'users.show-modal',
    'uses' => 'Common\UsersController@showModal',
]);
