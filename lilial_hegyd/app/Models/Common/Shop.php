<?php namespace App\Models\Common;


use App\Models\AbstractModel;
use Hegyd\Uploads\Models\Upload;
use Illuminate\Support\Facades\Input;

class Shop extends AbstractModel
{

    protected $table = 'shops';

    protected $fillable = [
        'active',
        'head_office',
        'name',
        'department',
        'client_code',
        'sector_code',
        'sector',
        'phone',
        'fax',
        'email',
        'director_email',
        'siren',
        'siret',
        'ape',
        'created_at_crm',
        'updated_at_crm',
        'code_type',
        'code_status',
        'sleeping',
        'billing_email',
        'company_id',
    ];

    protected $dates = [
        'created_at_crm',
        'updated_at_crm',
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
            'name'        => 'required',
            'client_code' => 'required',
            'email'       => "required|email",
        ];

        return $rules;
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'shop_user');
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function visual()
    {
        return $this->morphOne(Upload::class, 'uploadable');
    }

    public function defaultMedia()
    {
        return '/app/img/logo-gni.png';
    }

    public function ratio()
    {
        $image_url = $this->media();
        if ($image_url != $this->defaultMedia()) {
            return 1;
        }

        return 0.81;
    }
}
