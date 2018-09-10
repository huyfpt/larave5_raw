<?php namespace Hegyd\eCommerce\Models\ProductCatalog;


use Hegyd\eCommerce\Models\AbstractModel;

class ProductAttribute extends AbstractModel
{
    protected $fillable = [
        'product_id',
        'option_id',
    ];

    public $timestamps = false;
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('hegyd-ecommerce.tables.product_attributable');
    }


}