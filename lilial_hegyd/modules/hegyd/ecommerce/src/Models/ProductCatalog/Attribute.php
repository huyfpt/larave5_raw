<?php namespace Hegyd\eCommerce\Models\ProductCatalog;


use Hegyd\eCommerce\Models\AbstractModel;

class Attribute extends AbstractModel
{
    protected $fillable = [
        'name',
        'active',
    ];

    public $timestamps = false;
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('hegyd-ecommerce.tables.product_attribute');
    }

    public function option()
    {
        return $this->hasMany('\Hegyd\eCommerce\Models\ProductCatalog\AttributeOption', 'attribute_id');
    }

}