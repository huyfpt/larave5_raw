<?php namespace App\Repositories\Eloquent\Common;

use App\Models\Common\User;
use App\Repositories\Contracts\Common\UserRepositoryInterface;
use App\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

class UserRepository extends Repository implements UserRepositoryInterface
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Permits to attach a role to the current user
     * @param Role $role
     */
    public function attachRole($role)
    {
        // TODO: Implement attachRole() method.
    }

    /**
     * Permits to detach a role to the current user or detach all roles of role = null
     * @param array $roles or null
     */
    public function detachRoles($roles = null)
    {
        // TODO: Implement detachRoles() method.
    }

    /**
     * Permits to set the unique role to the current user
     * @param Role $role
     */
    public function setRole($role)
    {
        $this->model->roles()->sync([$role->id]);
    }

    /**
     * Permits to set the unique shop to the current user
     * @param Role $role
     */
    public function setShop($shop)
    {
        $this->model->shops()->sync([$shop->id]);
    }

    /**
     *
     * @param String $username
     * @return User
     */
    public function findByEmailAndLogin($username)
    {
        return User::where('username', '=', $username)->orWhere('email', '=', $username)->first();
    }

    /**
     * Find user by username
     *
     * @param type $username
     * @return User
     */
    public function findByLogin($username)
    {
        return $this->findByUsername($username);
    }

    /**
     * Find user by username
     * @param $username
     * @return mixed
     */
    public function findByUsername($username)
    {
        return User::where('username', $username)->first();
    }

    /**
     * Find user by email
     *
     * @param type $email
     * @return User
     */
    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    /**
     * Find user by remember token
     * @param $token
     * @return mixed
     */
    public function findByRememberToken($token)
    {
        return User::where('remember_token', '=', $token)->first();
    }


    public function findByTermAndRole($term, $role_name = null, $limit = 0)
    {

        $query = User::select('users.*')
            ->where('users.active', true)
            ->where(function ($q) use ($term) {
                return $q->where('users.firstname', 'like', $term . '%')
                    ->orWhere('users.lastname', 'like', $term . '%')
                    ->orWhere('users.username', 'like', $term . '%')
                    ->orWhere('users.email', 'like', $term . '%');
            });

        if ($role_name)
        {

            $query->join('shop_user', 'users.id', '=', 'shop_user.user_id')
                ->join('roles', 'shop_user.role_id', '=', 'roles.id')
                ->where('roles.name', $role_name);
        }

        if ($limit)
        {
            $query->limit($limit);
        }

        $query->orderBy('users.lastname')
            ->orderBy('users.firstname');

        return $query->get();
    }


    public function findByRole($role_name, $limit = 0)
    {
        $query = User::select('users.*')->where('users.active', true);
        $query->join('shop_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name', $role_name);

        if ($limit)
        {
            $query->limit($limit);
        }

        $query->orderBy('users.lastname')
            ->orderBy('users.firstname');

        return $query->get();
    }

    public function findByPermission($permission_name, $limit = 0)
    {
        $query = User::select('users.*')->where('users.active', true);
        $query->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->join('permission_role', 'permission_role.role_id', '=', 'roles.id')
            ->join('permissions', 'permission_role.permission_id', '=', 'permissions.id')
            ->where('permissions.name', $permission_name);

        if ($limit)
        {
            $query->limit($limit);
        }

        return $query->get();
    }

    public function getAdminUsers()
    {
        $query = User::select('users.*')->where('users.active', true);
        $query->join('shop_user', 'users.id', '=', 'shop_user.user_id')
            ->join('roles', 'shop_user.role_id', '=', 'roles.id')
            ->whereIn('roles.name', ['admin', 'super_admin']);

        return $query->get();
    }

    /**
     * Retrieve all users list for select form field as fullname mode
     * @return array
     */
    public function populateFullname()
    {
        return User::select(DB::raw("CONCAT(firstname,' ',lastname) AS fullname"), 'id')
            ->orderBy('firstname', 'ASC')
            ->pluck('fullname', 'id')
            ->toArray();
    }

    public function active()
    {
        return User::where('active', true)
            ->orderBy('lastname')
            ->orderBy('firstname')
            ->get();
    }

    public function unreadNotifications(User $user, $limit = 5)
    {
        return $user->unreadNotifications()
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();
    }

    public function search($term, $roles = [], $limit = 10)
    {
        $users = User::select('users.*')
            ->where('users.active', true)
            ->where(function ($query) use ($term) {
                $query->where('firstname', 'like', "%$term%")
                    ->orWhere('lastname', 'like', "%$term%")
                    ->orWhere('email', 'like', "%$term%")
                    ->orWhereRaw("CONCAT(firstname, ' ', lastname) like '%$term%'")
                    ->orWhereRaw("CONCAT(lastname, ' ', firstname) like '%$term%'");
            });

        if (count($roles))
        {
            $users->join('shop_user', 'users.id', '=', 'shop_user.user_id')
                ->join('roles', 'roles.id', '=', 'shop_user.role_id')
                ->whereIn('roles.name', $roles);
        }

        $users->limit($limit);

        return $users->get();
    }
}