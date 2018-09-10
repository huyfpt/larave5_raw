<?php 

namespace App\Models\Common;

use Carbon\Carbon;
use Hegyd\Permissions\Models\Role;
use Hegyd\Uploads\Models\Upload;
use Illuminate\Support\Str;
use Hegyd\News\Models\AbstractModel;
use App\Facades\AppTools;

class News extends AbstractModel
{

//    private $user_class;
//    private $category_class;
//    private $role_class;

    protected $dates = [
        'start_at',
        'end_at',
    ];

    protected $fillable = [
        'active',
        'name',
        'content',
        'display_on_slider',
        'start_at',
        'end_at',
        'category_id',
        'author_id',
        'enable_comment',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'meta_robots',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    const INDEX_FOLLOW = 'INDEX, FOLLOW';
    const NOINDEX_FOLLOW = 'NOINDEX, FOLLOW';
    const INDEX_NOFOLLOW = 'INDEX, NOFOLLOW';
    const NOINDEX_NOFOLLOW = 'NOINDEX, NOFOLLOW';

//    public function __construct(array $attributes = [])
//    {
//        parent::__construct($attributes);
//        $this->table = config('hegyd-news.tables.news');
//        $this->user_class = config('hegyd-news.models.user');
//        $this->category_class = config('hegyd-news.models.news_category');
//        $this->role_class = config('hegyd-news.models.role');
//    }
//    
   

    protected function rules()
    {
        $except_id = $this->exists ? ',' . $this->id : '';
        $required_if_not_exists = $this->exists ? '' : '|required';
        // $start_date = ($this->exists && !empty($this->start_at)) ? 'after_or_equal:'.date('Y-m-d', strtotime($this->start_at)) : 'after_or_equal:today';
        $start_date = $this->exists  ? '' : 'after_or_equal:today';

        $rules = [
            'name'    => 'required|max:255|unique:news,name'.$except_id.$required_if_not_exists,
            'content' => 'required',
            'slug'    => 'required|unique:news,slug'.$except_id.$required_if_not_exists,
            'start_at'      => [
              'nullable',
              $start_date,
            ],
            'end_at'        => [
              'nullable',
              'after:start_at',
            ],
        ];

        return $rules;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(config('hegyd-news.models.news_category'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(config('hegyd-news.models.user'));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'news_role');
    }

    public function comments()
    {
        return $this->hasMany(config('hegyd-news.models.news_comment'), 'news_id');
    }

    public function likes()
    {
        return $this->hasMany(config('hegyd-news.models.news_like'), 'news_id');
    }

    /**
     * @return mixed
     */
    public function publishDate()
    {
        if ($this->start_at)
            return $this->start_at;

        return $this->created_at;
    }

    /**
     * @return string
     */
    public function url()
    {
        $slug = '';

        if ($this->category)
        {
            $slug .= Str::slug($this->category->name) . '/';
        }

        $slug .= Str::slug($this->name);

        return route(config('hegyd-news.routes.frontend.news.show'), ['slug' => $slug, 'id' => $this->id]);
    }

    /**
     * Check if news is available
     * @return bool
     */
    public function isActive()
    {
        $is_active = false;

        if ($this->active && $this->category && $this->category->active)
        {
            $now = Carbon::now();
            
            if (( ! $this->start_at || $this->start_at->lte($now)) && ( ! $this->end_at || $this->end_at->gte($now)))
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

    public function visualSlider()
    {
        return $this->morphOne(Upload::class, 'uploadable')->where('type', Upload::TYPE_SECOND_VISUAL);
    }

    /**
     * Default media
     *
     * @return string
     */
    public function defaultMedia()
    {
        return '/vendor/hegyd/news/img/default_news.jpg';
    }

    /**
     * @param bool $plurial
     * @return string
     */
    public function getName($plurial = false)
    {
        if ($plurial)
            return 'news';


        return 'news';
    }

    public function metaRobots()
    {
        $array = [
            News::INDEX_FOLLOW => News::INDEX_FOLLOW,
            News::NOINDEX_FOLLOW => News::NOINDEX_FOLLOW,
            News::INDEX_NOFOLLOW => News::INDEX_NOFOLLOW,
            News::NOINDEX_NOFOLLOW => News::NOINDEX_NOFOLLOW,
        ];
        return $array;
    }
}