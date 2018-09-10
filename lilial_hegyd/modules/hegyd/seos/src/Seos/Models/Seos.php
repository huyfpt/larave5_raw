<?php

namespace Hegyd\Seos\Models;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Model;

class Seos extends AbstractModel
{
    protected $fillable = [
        'id',
        'description',
        'created_at',
        'url',
        'active',
        'h1',
        'meta_title',
        'title',
        'meta_description',
        'meta_keyword',
        'meta_robots',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
      ];
    public $timestamps = true;
    
        /**
     * @return mixed
     */
    public function publishDate()
    {

        return $this->created_at;
    }

    protected function rules()
    {
        $except_id = $this->exists ? ',' . $this->id : '';
        //$required_if_not_exists = $this->exists ? '' : '|required';
        
        $rules = [
            'url'           => [
                'required',
                'unique:seos,url'.$except_id,
                function($attribute, $value, $fail) {
                    $pattern = '/(?:https?:\/\/)?(?:[a-zA-Z0-9.-]+?\.(?:[a-zA-Z])|\d+\.\d+\.\d+\.\d+)/';
                    if(!preg_match($pattern, $value)) {
                        return $fail("Le format de l'URL de URL n'est pas valide.");
                    }
                },
            ]
        ];
    
        return $rules;

    }

    public function visual()
    {
        return $this->morphOne(Upload::class, 'uploadable')->where('type', Upload::TYPE_MAIN_VISUAL);
    }

}
