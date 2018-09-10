<?php namespace App\Models\Common;


use App\Models\AbstractModel;
use App\Models\Content\Setting;
use App\Models\EDM\Upload;

class Company extends AbstractModel
{

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'subdomain',
        'active'
    ];


    public function settings()
    {
        return $this->morphMany(Setting::class, 'settingable');
    }
}