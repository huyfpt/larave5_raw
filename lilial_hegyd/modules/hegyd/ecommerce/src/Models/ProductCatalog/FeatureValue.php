<?php namespace Hegyd\eCommerce\Models\ProductCatalog;


use Hegyd\eCommerce\Models\AbstractModel;

class FeatureValue extends AbstractModel
{
    protected $fillable = [
        'product_id',
        'option_id',
        'value',
    ];

    public $timestamps = false;
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('hegyd-ecommerce.tables.product_feature_value');
    }


}