<?php

namespace App\Models\Common;

use App\Models\AbstractModel;
use Carbon\Carbon;
use Hegyd\Permissions\Models\Role;
use Hegyd\Uploads\Models\Upload;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Cache\TaggableStore;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Zizaco\Entrust\Traits\EntrustUserTrait;


class User extends AbstractModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{

    use Authenticatable, Authorizable, CanResetPassword, SoftDeletes,
        EntrustUserTrait
    {
        SoftDeletes::restore insteadof EntrustUserTrait;
        EntrustUserTrait::can insteadof Authorizable;
    }

    use Notifiable;

    const CIVILITY_MISTER = 1;
    const CIVILITY_MADAM = 2;
    const ROLE_SUPER = 1;
    const ROLE_ADMIN = 2;
    const ROLE_USER = 3;
    const ROLE_CLIENT = 4;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'username',
        'firstname',
        'lastname',
        'civility',
        'email',
        'password',
        'phone',
        'mobile',
        'creator_id',
        'updator_id',
        'newsletter',
        'created_at',
        'role_id',
        'active',
    ];

    protected $dates = [
        'birth_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Validation rules
     *
     * @return array
     */
    protected function rules()
    {
        $except_id = $this->exists ? ',' . $this->id : '';
        $required_if_not_exists = $this->exists ? '' : '|required';

        $rules = [
            'civility'  => 'required',
            'firstname' => 'required',
            'lastname'  => 'required',
            'email'     => "required|email|unique:users,email$except_id$required_if_not_exists",
            'username'  => "required|unique:users,username$except_id$required_if_not_exists",
            'password'  => 'min:8|confirmed'.$required_if_not_exists,
            'mobile'    => [
                'nullable',
                'regex:/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/',
            ],
            'phone'    => [
                'nullable',
                'regex:/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/',
            ],
        ];

        return $rules;
    }

    public function shops()
    {
        return $this->belongsToMany(Shop::class, 'shop_user');
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }


    public function fullname($reverse = false)
    {
        if ($reverse)
            return $this->lastname . ' ' . $this->firstname;

        return $this->firstname . ' ' . $this->lastname;
    }

    public function shortName($reverse = false)
    {
        if ($reverse)
            return $this->lastname . ' ' . Str::limit($this->firstname, 1, '.');

        return $this->firstname . ' ' . Str::limit($this->lastname, 1, '.');
    }

    public function visual()
    {
        return $this->morphOne(Upload::class, 'uploadable');
    }


    /**
     * Default media
     *
     * @return string
     */
    public function defaultMedia()
    {
        return '/app/img/default_user.png';
    }

    // TODO Implémenter le filtre par shop_user
    public function cachedRoles()
    {
        return $this->roles()->get(); // Filtrer par shop_id
    }

    public function getLastId()
    {
        $id = $this->orderBy('id', 'desc')->pluck('id')->first();
        return $id;
    }

    public function checkRoleClient($user)
    {
        if($user->role_id == User::ROLE_CLIENT)
            return true;
        else
            return false;
    }

    public function storeClient($user, $data)
    {
        $client = Client::where('user_id', $user->id)->first();

        if($data['role_id'] == User::ROLE_CLIENT && empty($client))
        {
            Client::create(['user_id' => $user->id]);
        }
    }

    public function deleteClient($id)
    {
        $client = Client::where('user_id', $id)->first();
        if($client) {
            $client->delete();
        }
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
