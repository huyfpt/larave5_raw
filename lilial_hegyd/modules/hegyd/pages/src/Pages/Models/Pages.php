<?php

namespace Hegyd\Pages\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Pages extends AbstractModel
{
    protected $fillable = [
        'id',
        'content',
        'created_at',
        'description',
        'status',
        'title',
        'slug',
        'updated_at',
        'user_id',
        'meta_title',
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
        $required_if_not_exists = $this->exists ? '' : '|required';

        $rules = [
            'content'       => 'required',
            'meta_title'       => 'required',
            'meta_description'       => 'required',
            'title'       => 'required',
            'slug'          =>  'required|unique:pages,slug'.$except_id.$required_if_not_exists,
        ];

        return $rules;
    }
    /**
     * @return string
     */
    public function url()
    {
        $slug = '';

        $slug .= Str::slug($this->title);

        return route(config('hegyd-pages.routes.frontend.pages.show'), ['slug' => $slug, 'id' => $this->id]);
    }

    /**
     * Check if pages is available
     * @return bool
     */
    public function isActive()
    {
        $is_active = false;

        if ($this->status)
        {
            $now = Carbon::now();
            
            if (( ! $this->created_at || $this->created_at->lte($now)) && ( ! $this->updated_at || $this->updated_at->gte($now)))
            {
                $is_active = true;
            }
        }

        return $is_active;
    }

    public function visual()
    {
        return $this->morphOne(Upload::class, 'uploadable')->where('type', Upload::TYPE_MAIN_VISUAL);
    }

    /**
     * Default media
     *
     * @return string
     */
    public function defaultMedia()
    {
        return '/vendor/hegyd/pages/img/default_news.jpg';
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

}
