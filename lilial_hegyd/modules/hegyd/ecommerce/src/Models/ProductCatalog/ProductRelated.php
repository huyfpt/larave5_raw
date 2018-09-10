<?php namespace Hegyd\eCommerce\Models\ProductCatalog;


use Hegyd\eCommerce\Models\AbstractModel;

class ProductRelated extends AbstractModel
{
    protected $fillable = [
        'product_id',
        'related_id'
    ];

    public $timestamps = false;
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('hegyd-ecommerce.tables.product_related');
    }

    public function product()
    {
        return $this->belongsTo( config('hegyd-ecommerce.models.product') );
    }

    public function updateRelated($product_id, $data_related)
    {
        if (!self::_checkChanged($product_id, $data_related)) {
            return false;
        }

        ProductRelated::where('product_id', $product_id)->delete();

        if (!empty($data_related)) {

            $data = [];
            foreach ($data_related as $related_id) {
                $data[] = ['related_id' => $related_id, 'product_id' => $product_id];
            }

            ProductRelated::insert($data);
        }
    }

    protected static function _checkChanged($product_id, $data_related)
    {
        $data = ProductRelated::where('product_id', $product_id)->get();

        if (!empty($data)) {

            if (count($data) != count($data_related)) {
                return true;
            }

            foreach ($data as $item) {
                if (!in_array($item->related_id, $data_related)) {
                    return true;
                }
            }
        }

        return false;
    }


}