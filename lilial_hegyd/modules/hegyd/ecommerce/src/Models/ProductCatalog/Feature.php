<?php namespace Hegyd\eCommerce\Models\ProductCatalog;


use Hegyd\eCommerce\Models\AbstractModel;

class Feature extends AbstractModel
{
    protected $fillable = [
        'name',
        'active',
    ];

    public $timestamps = false;
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('hegyd-ecommerce.tables.product_feature');
    }

    public function Option()
    {
        return $this->hasMany( config('hegyd-ecommerce.models.feature_option') );
    }


}