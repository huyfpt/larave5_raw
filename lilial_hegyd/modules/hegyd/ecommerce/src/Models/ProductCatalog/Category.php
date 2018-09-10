<?php namespace Hegyd\eCommerce\Models\ProductCatalog;

use Hegyd\eCommerce\Models\AbstractModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Cviebrock\EloquentSluggable\Sluggable;

/**
 * App\Models\ProductCatalog\Category
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductCatalog\Category whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductCatalog\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductCatalog\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property boolean $active
 * @property string $name
 * @property string $description
 * @property string $deleted_at
 * @property-read \App\Models\ProductCatalog\Category $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductCatalog\Category[] $children
 * @property-read \App\Models\ProductCatalog\Category $root
 * @property-read \App\Models\Site\Universe $universe
 * @property-read \App\Models\EDM\Upload $visual
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductCatalog\Product[] $products
 * @property-read mixed $path
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductCatalog\Category whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductCatalog\Category whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductCatalog\Category whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductCatalog\Category wherePosition($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductCatalog\Category whereHeliosId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductCatalog\Category whereHeliosCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductCatalog\Category whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductCatalog\Category whereRootId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductCatalog\Category whereUniverseId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductCatalog\Category whereVisualId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductCatalog\Category whereDeletedAt($value)
 */
class Category extends AbstractModel
{

    use SoftDeletes;
    use Sluggable;
    
    private $product_class;
    private $upload_class;

    protected $fillable = [
        'active',
        'name',
        'slug',
        'description',
        'parent_id',
        'select_site',
        'trade',
        'accroche',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'ranking',

    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('hegyd-ecommerce.tables.category');
        $this->product_class = config('hegyd-ecommerce.models.product');
        $this->upload_class = config('hegyd-ecommerce.models.upload');
    }


    public function visual()
    {
        return $this->morphOne($this->upload_class, 'uploadable');
    }

    public function products()
    {
        return $this->hasMany($this->product_class);
    }

    public function canDelete()
    {
        if ($this->products->count())
        {
            return false;
        }

        if ($this->checkChild())
        {
            return false;
        }

        return true;
    }

    /**
     * Validation rules
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'name' => 'required',
        ];
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function url($returnRoute = true)
    {
        $return = '/' . Str::slug($this->name);

        if ($returnRoute)
        {
            $return = route('front::categories.index', ['slug' => $return, 'id' => $this->id]);
        }

        return $return;
    }

    public function checkChild()
    {
        return Category::where('parent_id', $this->id)->exists();
    }
}
