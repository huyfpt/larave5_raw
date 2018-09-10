<?php
namespace Hegyd\Faqs\Models;

use Hegyd\Uploads\Models\Upload;
use Illuminate\Support\Str;
use Hegyd\Faqs\Models\Faq;
/**
 * Class FaqsCategory
 * @package Hegyd\Faqs\Models
 */
class FaqsCategory extends AbstractModel
{

    protected $faqs_class;
    private $category_class;

    protected $fillable = [
        'label',
        'introduction',
        'image',
        'status',
        'parent_id'
    ];

    /**
     * FaqsCategory constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->faqs_class = config('hegyd-faqs.models.faqs');
        $this->category_class = config('hegyd-faqs.models.faqs_category');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function faqs()
    {
        return $this->hasMany($this->faqs_class, 'category_id');
    }

    public function parent()
    {
        return $this->belongsTo($this->category_class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany($this->category_class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function visual()
    {
        return $this->morphOne(Upload::class, 'uploadable');
    }

    /**
     *  Generate url for this model
     * @return string
     */
    public function url()
    {
        $slug = '';

        if ($this->id)
        {
            $slug .= Str::slug($this->label);
        }

        // $slug .= Str::slug($this->label);

        return route(config('hegyd-faqs.routes.frontend.faqs_category.show_list'), ['slug' => $slug, 'id' => $this->id]);
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
            'label' => 'required|unique:' . config('hegyd-faqs.tables.faqs_category') . ',label' . $except_id . '|max:255',
            'label' => 'difference_value:category_id'
        ];
    }

    /**
     * @param bool $plurial
     * @return string
     */
    public function getName($plurial = false)
    {
        if ($plurial)
            return 'faqs_categories';


        return 'faqs_category';
    }

    /**
     * Default media
     *
     * @return string
     */
    public function defaultMedia()
    {
        return '/vendor/hegyd/faqs/img/default_category.png';
    }

    public function deleteFaqs($category_id)
    {
        if($category_id)
        {
            Faqs::where('category_id', $category_id)->delete();
        }
    }

    public function messages()
    {
        return [
            'label.difference_value' => '',
            'category_id.difference_value'   => ''
        ];
    }
}