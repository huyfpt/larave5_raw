<?php

namespace App\Repositories\Contracts\Common;


use App\Models\ACL\Role;
use App\Models\Common\User;

interface UserRepositoryInterface
{

    /**
     * Permits to attach a role to the current user
     * @param Role $role
     */
    public function attachRole($role);

    /**
     * Permits to detach a role to the current user or detach all roles of role = null
     * @param array $roles or null
     */
    public function detachRoles($roles = null);

    /**
     * Permits to set the unique role to the current user
     * @param Role $role
     */
    public function setRole($role);

    /**
     * Permits to set the unique shop to the current user
     * @param Shop $shop
     */
    public function setShop($shop);

    /**
     *
     * @param String $login
     * @return User
     */
    public function findByEmailAndLogin($login);

    /**
     * Find user by login
     *
     * @param type $login
     * @return User
     */
    public function findByLogin($login);

    /**
     * Find user by username
     * @param $username
     * @return mixed
     */
    public function findByUsername($username);

    /**
     * Find user by email
     *
     * @param type $email
     * @return User
     */
    public function findByEmail($email);

    /**
     * Find user by remember token
     * @param $token
     * @return mixed
     */
    public function findByRememberToken($token);

    /**
     * Find user by name and role
     * @param $name
     * @param $role_name
     * @param $limit
     * @return mixed
     */
    public function findByTermAndRole($name, $role_name = null, $limit = 0);

    /**
     * Find user by role
     * @param $role_name
     * @param $limit
     * @return mixed
     */
    public function findByRole($role_name, $limit = 0);


    public function getAdminUsers();

    public function populateFullname();

    public function active();

    public function unreadNotifications(User $user, $limit = 5);

    public function search($term, $roles = [], $limit = 10);

}