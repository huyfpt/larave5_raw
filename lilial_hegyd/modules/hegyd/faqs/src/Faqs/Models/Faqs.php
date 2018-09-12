<?php
namespace Hegyd\Faqs\Models;

use Carbon\Carbon;
use Hegyd\Permissions\Models\Role;
use Hegyd\Uploads\Models\Upload;
use Illuminate\Support\Str;

class Faqs extends AbstractModel
{
    protected $dates = [
        'start_at',
        'end_at',
    ];

    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'status',
        'start_at',
        'end_at',
        'category_id',
        'author_id',
        'meta_robots'
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

        $rules = [
            'title'             => 'required|max:100',
            'content'           => 'required',
            'slug'              => 'required|unique:faqs,slug'.$except_id.$required_if_not_exists,
            'meta_title'        => 'required|max:100',
            'meta_description'  => 'required',
            'meta_keyword'      => 'max:100',
            'start_at'          => 'greater_than_field:end_at'
        ];

        return $rules;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(config('hegyd-faqs.models.faqs_category'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(config('hegyd-faqs.models.user'));
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

        return route(config('hegyd-faqs.routes.frontend.faqs.show'), ['slug' => $slug, 'id' => $this->id]);
    }

    /**
     * Check if faqs is available
     * @return bool
     */
    public function isActive()
    {
        $is_active = false;

        if ($this->status && $this->category && $this->category->status)
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

    public function visualDocument()
    {
        return $this->morphOne(Upload::class, 'uploadable')->where('type', Upload::TYPE_DOCUMENTS);
    }

    /**
     * Default media
     *
     * @return string
     */
    public function defaultMedia()
    {
        return '/vendor/hegyd/faqs/img/default_faqs.jpg';
    }

    public function messages()
    {
        return [
            'start_at.greater_than_field' => '',
            'end_at.greater_than_field'   => ''
        ];
    }
}