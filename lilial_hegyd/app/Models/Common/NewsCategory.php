<?php

namespace App\Models\Common;

use Hegyd\Uploads\Models\Upload;
use Illuminate\Support\Str;
use Hegyd\News\Models\AbstractModel;
use App\Facades\AppTools;

/**
 * Class NewsCategory
 * @package Hegyd\News\Models
 */
class NewsCategory extends AbstractModel
{

    protected $news_class;

    protected $fillable = [
        'active',
        'name',
        'parent_id',
        'grip',
    ];

    /**
     * NewsCategory constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->news_class = config('hegyd-news.models.news');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function news()
    {
        return $this->hasMany($this->news_class, 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function visual()
    {
        return $this->morphOne(Upload::class, 'uploadable');
    }

    /**
     * @return string
     */
    public function url()
    {
        return route(config('hegyd-news.routes.frontend.news_category.show'), ['slug' => Str::slug($this->name), 'id' => $this->id]);
    }

    /**
     * Validation rules
     *
     * @return array
     */
    protected function rules()
    {
        $except_id = $this->exists ? ',' . $this->id : '';

        return [
            'name' => 'required|unique:' . config('hegyd-news.tables.news_category') . ',name' . $except_id . '|max:50',
            'grip' => 'required',
        ];
    }

    /**
     * @param bool $plurial
     * @return string
     */
    public function getName($plurial = false)
    {
        if ($plurial)
            return 'news_categories';


        return 'news_category';
    }

    /**
     * Default media
     *
     * @return string
     */
    public function defaultMedia()
    {
        return '/vendor/hegyd/news/img/default_category.png';
    }

    public static function getCategoryName($id)
    {
        return NewsCategory::where('id', $id)->pluck('name')->first();
    }

    public static function processName($parent_id, $name)
    {
        if($parent_id == 0)
        {

            if(strstr($name, '|') == true)
            {
                $strFind = substr($name, 0, strpos($name, '|')+1);
                $name = str_replace($strFind, '', $name);
            }
        } else
        {
            if(strstr($name, '|') == true)
            {
                $strFind = substr($name, 0, strpos($name, '|')-1);
                $name = str_replace($strFind, NewsCategory::getCategoryName($parent_id), $name);
            } else
            {
                $name = NewsCategory::getCategoryName($parent_id).' | '.$name;
            }
        }

        return trim($name);
    }
}