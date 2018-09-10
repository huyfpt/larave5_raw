<?php


namespace App\Repositories\Contracts\ACL;


interface RoleRepositoryInterface
{

    public function searchByTerm($term);

    public function getAll($withSuperAdmin);

    public function getAdminRoles();

    public function getOthers();

}