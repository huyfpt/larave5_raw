<?php namespace Hegyd\eCommerce\Models\ProductCatalog;

use Hegyd\eCommerce\Models\AbstractModel;
use Hegyd\eCommerce\Models\eCommerce\OrderLine;
use Hegyd\Uploads\Models\Upload;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

/**
 * App\Models\ProductCatalog\Product
 */
class Product extends AbstractModel
{

    use SoftDeletes;
    use Sluggable;

    private $upload_class;
    private $category_class;
    private $vat_class;
    private $order_line_class;
    private $cart_line_class;
    private $category_table;

    protected $fillable = [
        'active',
        'name',
        'reference',
        'description',
        'grip',
        'brand_id',
        'category_id',
        'table_declension',
        'meta_robots',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $addToNiceNames = ['category_id' => 'category'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('hegyd-ecommerce.tables.product');
        $this->upload_class = config('hegyd-ecommerce.models.upload');
        $this->category_class = config('hegyd-ecommerce.models.category');
        $this->vat_class = config('hegyd-ecommerce.models.vat');
        $this->order_line_class = config('hegyd-ecommerce.models.order_line');
        $this->cart_line_class = config('hegyd-ecommerce.models.cart_line');
        $this->category_table = config('hegyd-ecommerce.tables.category');
    }

    /**
     * Relations
     */

    public function category()
    {
        return $this->belongsTo($this->category_class, 'category_id');
    }

    public function visual()
    {
        return $this->morphOne($this->upload_class, 'uploadable')
            ->select('uploads.*')
            ->where('uploads.type', Upload::TYPE_MAIN_VISUAL);
//            ->join('folders', 'uploads.folder_id', '=', 'folders.id')
//            ->where('folders.type', Folder::TYPE_PRODUCT_VISUAL);
    }

    public function visuals()
    {
        return $this->morphMany($this->upload_class, 'uploadable')
            ->select('uploads.*')
            ->where('uploads.type', Upload::TYPE_SECOND_VISUAL);
//            ->join('folders', 'uploads.folder_id', '=', 'folders.id')
//            ->where('folders.type', Folder::TYPE_PRODUCT_SUBVISUAL);
    }

    public function vat()
    {
        return $this->belongsTo($this->vat_class);
    }

    public function brand()
    {
        return $this->belongsTo( config('hegyd-ecommerce.models.brand') );
    }

    public function orderLines()
    {
        return $this->hasMany($this->order_line_class);
    }

    public function cartLines()
    {
        return $this->hasMany($this->cart_line_class);
    }

    public function productRelated()
    {
        return $this->hasMany( config('hegyd-ecommerce.models.product_related') );
    }

    public function productFaq()
    {
        return $this->hasMany( config('hegyd-ecommerce.models.product_faq') );
    }

    public function productFeature()
    {
        return $this->hasMany( config('hegyd-ecommerce.models.product_feature') );
    }


    public function faqs()
    {
        return $this->belongsToMany( config('hegyd-ecommerce.models.faqs'), 'product_faqs', 'product_id', 'faq_id' );
    }

    /**
     * Validation rules
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'name'        => 'required|max:128',
            'reference'   => 'required|unique:' . $this->table . ',reference,' . ($this->exists ? $this->id : 'NULL') . ',id,deleted_at,NULL',
            'category_id' => 'required|exists:' . $this->category_table . ',id',
            'stock'       => 'integer|min:0',
        ];
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where('name', 'like', '%' .$keyword. '%');
    }

    public function scopeFilterReference($query, $keyword)
    {
        return $query->where('reference', 'like', '%' .$keyword. '%');
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

    public function url($site = null)
    {
//        if ($site)
//        {
//            return RoutesTools::getFullDomain($site->subdomain) . '/' . Str::slug($this->name) . '-p' . $this->id;
//        } else
//        {
//            return route('front::products.show', ['slug' => Str::slug($this->name), 'id' => $this->id]);
//        }
    }

    public function title()
    {
        return $this->reference . ' - ' . $this->name;
    }

    /**
     * Default media
     *
     * @return string
     */
    public function defaultMedia()
    {
        return '/vendor/hegyd/ecommerce/img/default-img.gif';
    }

    public function getFieldExport()
    {
        return [
            'name',
            'reference',
            'visual',
            'brand',
            'category',
            'description'
        ];   
    }
}