<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;

class SettingCategory extends Model
{

    protected $table = 'setting_categories';

    protected $fillable = [
        'name',
        'key',
    ];


    public function settings()
    {
        return $this->hasMany(Setting::class, 'category_id');
    }
}