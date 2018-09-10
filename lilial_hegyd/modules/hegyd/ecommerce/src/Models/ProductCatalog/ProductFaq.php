<?php namespace Hegyd\eCommerce\Models\ProductCatalog;


use Hegyd\eCommerce\Models\AbstractModel;

class ProductFaq extends AbstractModel
{
    protected $fillable = [
        'product_id',
        'faq_id'
    ];

    public $timestamps = false;
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('hegyd-ecommerce.tables.product_faq');
    }

    public function updateFaq($product_id, $data_faq)
    {
        if (!self::_checkChanged($product_id, $data_faq)) {
            return false;
        }

        ProductFaq::where('product_id', $product_id)->delete();

        if (!empty($data_faq)) {

            $data = [];
            foreach ($data_faq as $faq_id) {
                $data[] = ['faq_id' => $faq_id, 'product_id' => $product_id];
            }

            ProductFaq::insert($data);
        }
    }

    protected static function _checkChanged($product_id, $data_faq)
    {
        $data = ProductFaq::where('product_id', $product_id)->get();

        if (!empty($data)) {

            if (count($data) != count($data_faq)) {
                return true;
            }

            foreach ($data as $item) {
                if (!in_array($item->faq_id, $data_faq)) {
                    return true;
                }
            }
        }

        return false;
    }

}