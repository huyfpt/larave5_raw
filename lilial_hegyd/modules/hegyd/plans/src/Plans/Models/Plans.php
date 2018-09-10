<?php namespace Hegyd\Plans\Models;

use Carbon\Carbon;
use Hegyd\Permissions\Models\Role;
use Hegyd\Uploads\Models\Upload;
use Illuminate\Support\Str;
use App\Models\Common\Address;

class Plans extends AbstractModel
{
    protected $dates = [
        'start_at',
        'end_at',
    ];

    protected $fillable = [
        'active',
        'title',
        'content',
        'start_at',
        'end_at',
        'category_id',
        'author_id',
        'avantage',
        'visibility',
        'url',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'meta_robots',
    ];

    protected $casts = [
      'created_at' => 'datetime:Y-m-d',
      'start_at' => 'datetime:Y-m-d',
      'end_at' => 'datetime:Y-m-d',
    ];

    const INDEX_FOLLOW = 'INDEX, FOLLOW';
    const NOINDEX_FOLLOW = 'NOINDEX, FOLLOW';
    const INDEX_NOFOLLOW = 'INDEX, NOFOLLOW';
    const NOINDEX_NOFOLLOW = 'NOINDEX, NOFOLLOW';

    /**
     * Validation rules
     *
     * @return array
     */
    protected function rules()
    {
        $except_id = $this->exists ? ',' . $this->id : '';
        $required_if_not_exists = $this->exists ? '' : '|required';
        // $start_date = ($this->exists && !empty($this->start_at)) ? 'after_or_equal:'.date('Y-m-d', strtotime($this->start_at)) : 'after_or_equal:today';
        $start_date = $this->exists  ? '' : 'after_or_equal:today';

        $rules = [
            'title'         => 'required|max:255'.$except_id.$required_if_not_exists,
            'content'       => 'required',
            'url'           => 'url',
            'slug'          => 'required|unique:plans,slug'.$except_id.$required_if_not_exists,
            'meta_title'    => 'max:50',
            'meta_keyword'  => 'max:50',
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
        return $this->belongsTo(config('hegyd-plans.models.plans_category'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(config('hegyd-plans.models.user'));
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
     * Check if plans is available
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

    /**
     * Default media
     *
     * @return string
     */
    public function defaultMedia()
    {
        return '/vendor/hegyd/plans/img/default_plans.jpg';
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function getName($plurial = false)
    {
        if ($plurial)
            return 'plans';


        return 'plans';
    }
}