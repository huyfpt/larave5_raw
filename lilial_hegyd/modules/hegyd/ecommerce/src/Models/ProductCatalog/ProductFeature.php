<?php namespace Hegyd\eCommerce\Models\ProductCatalog;


use Hegyd\eCommerce\Models\AbstractModel;

class ProductFeature extends AbstractModel
{
    protected $fillable = [
        'product_id',
        'option_id',
        'value'
    ];

    public $timestamps = false;
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('hegyd-ecommerce.tables.product_feature_value');
    }

    public function updateFeature($product_id, $data_feature)
    {
        ProductFeature::where('product_id', $product_id)->delete();

        if (!empty($data_feature)) {

            $data = [];
            foreach ($data_feature as $option_id) {
                if (!empty($option_id)) {
                    $data[] = ['option_id' => $option_id, 'product_id' => $product_id];
                }
            }

            ProductFeature::insert($data);
        }
    }

}