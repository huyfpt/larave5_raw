<?php namespace Hegyd\Plans\Models;

use Hegyd\Uploads\Models\Upload;
use Illuminate\Support\Str;
use Hegyd\Plans\Models\Plans;

/**
 * Class PlansCategory
 * @package Hegyd\Plans\Models
 */
class PlansCategory extends AbstractModel
{

    protected $plans_class;

    protected $fillable = [
        'active',
        'name',
        'parent_id',
        'grip',
    ];

    /**
     * PlansCategory constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->plans_class = config('hegyd-plans.models.plans');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plans()
    {
        return $this->hasMany($this->plans_class, 'category_id');
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
        return route(config('hegyd-plans.routes.frontend.plans_category.show'), ['slug' => Str::slug($this->name), 'id' => $this->id]);
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
            'name' => 'required|unique:' . config('hegyd-plans.tables.plans_category') . ',name' . $except_id . '|max:50',
            'grip' => 'max:100',
        ];
    }

    /**
     * @param bool $plurial
     * @return string
     */
    public function getName($plurial = false)
    {
        if ($plurial)
            return 'plans_categories';


        return 'plans_category';
    }

    /**
     * Default media
     *
     * @return string
     */
    public function defaultMedia()
    {
        return '/vendor/hegyd/plans/img/default_category.png';
    }

    public function deletePlans($category_id)
    {
        if($category_id)
        {
            Plans::where('category_id', $category_id)->delete();
        }
    }
}