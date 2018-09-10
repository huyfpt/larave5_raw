<?php

namespace App\Repositories\Eloquent\ACL;

use App\Facades\AppTools;
use App\Repositories\Contracts\ACL\RoleRepositoryInterface;
use App\Repositories\Eloquent\Repository;
use Hegyd\Permissions\Models\Role;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository extends Repository implements RoleRepositoryInterface
{
    protected $admin_roles = ['super_admin', 'admin'];

    public function model()
    {
        return Role::class;
    }

    public function searchByTerm($term)
    {
        return Role::where('display_name', 'like', '%' . $term . '%')->get();
    }

    public function getAll($withSuperAdmin = false)
    {
        $user = auth()->user();
        if ( ! $user)
            return new Collection();

        // Récupération des roles de l’utilisateur courant
        $user_role = $user->cachedRoles()->pluck("name");

        // Filtre pour ne pas afficher super_admin au admin
        if ( ! $user_role->contains("super_admin"))
        {
            // Tous sauf le role super_admin
            return Role::where("name", "!=", "super_admin")->get();
        } else
        {
            // Tous
            return Role::all();
        }
    }

    /**
     * Retourne uniquement les roles "admin"
     * @return mixed
     */
    public function getAdminRoles()
    {
        return $this->makeModel()->whereIn('name', $this->admin_roles)->get();
    }

    /**
     * Retourne les roles autres que ceux "admin"
     * @return mixed
     */
    public function getOthers()
    {
        return $this->makeModel()->whereNotIn('name', $this->admin_roles)->get();
    }

}