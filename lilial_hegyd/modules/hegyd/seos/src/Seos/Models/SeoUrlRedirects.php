<?php

namespace Hegyd\Seos\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SeoUrlRedirects extends AbstractModel
{
    protected $fillable = [
        'id',
        'active',
        'new_url',
        'old_url',
    ];

    public $timestamps = false;
       
    protected function rules()
    {
        $except_id = $this->exists ? ',' . $this->id : '';
        $required_if_not_exists = $this->exists ? '' : '|required';

        $rules = [
            'new_url'           => 'required|unique:seo_url_redirects,new_url' .$except_id.$required_if_not_exists,
            'old_url'           => 'required|unique:seo_url_redirects,old_url'.$except_id.$required_if_not_exists,
        ];

        return $rules;
    }

    public function visual()
    {
        return $this->morphOne(Upload::class, 'uploadable')->where('type', Upload::TYPE_MAIN_VISUAL);
    }

}
