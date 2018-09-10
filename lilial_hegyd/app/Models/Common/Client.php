<?php namespace App\Models\Common;

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


class Client extends AbstractModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{

    use Authenticatable, Authorizable, CanResetPassword,
        EntrustUserTrait
    {
        EntrustUserTrait::can insteadof Authorizable;
    }

    use Notifiable;

    const TYPE_USER = 1;
    const TYPE_PROFESSIONAL = 2;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'club_lilial',
        'ambassador',
        'type',
    ];

    protected $dates = [
        'birth_at',
    ];

    /**
     * Validation rules
     *
     * @return array
     */
    protected function rules()
    {
        $except_id = $this->exists ? ',' . $this->user_id : '';
        $required_if_not_exists = $this->exists ? '' : '|required';

        $rules = [
            'email'     => "required|email|unique:users,email$except_id$required_if_not_exists",
            'password'  => 'min:8|confirmed'.$required_if_not_exists,
            'mobile'    => [
                'nullable',
                'regex:/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/',
            ],
        ];

        return $rules;
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUserId($id)
    {
        return Client::where('id', $id)->pluck('user_id')->first();
    }

    public function getLastUserId()
    {
        $id = User::orderBy('id', 'desc')->pluck('id')->first();
        return $id;
    }

    public function storeUser($data)
    {
        $username = str_slug($data['firstname']).'_'.rand(0, 99999);
        $data['username'] = $username;
        $user = User::create($data);
        return $user;
    }

    public function updateUser($id, $data)
    {
        $user = User::find($id);
        if($user) {
            $user->update($data);
        }
    }

    public function deleteUser($id)
    {
        $user_id = Client::getUserId($id);
        if($user_id) {
            $user = User::find($user_id);
            if($user) {
                $user->delete();
            }
        }
    }
}
