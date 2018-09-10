<?php namespace Hegyd\eCommerce\Models\eCommerce;

use Hegyd\eCommerce\Models\AbstractModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Hegyd\eCommerce\Models\eCommerce\OrderLine
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Hegyd\eCommerce\Models\eCommerce\OrderLine whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hegyd\eCommerce\Models\eCommerce\OrderLine whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Hegyd\eCommerce\Models\eCommerce\OrderLine whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderLine extends AbstractModel
{

    private $product_class;
    private $order_class;

    protected $fillable = [
        'product_reference',
        'product_name',
        'product_feature_value',
        'product_id',
        'unit_price_ht',
        'vat_rate',
        'vat_amount',
        'quantity',
        'total_ht',
        'total_ttc',
        'order_id',
        'product_id',
    ];

    protected $casts = [
        'product_id'    => 'int',
        'unit_price_ht' => 'double',
        'vat_rate'      => 'double',
        'vat_amount'    => 'double',
        'quantity'      => 'int',
        'total_ht'      => 'double',
        'total_ttc'     => 'double',
        'order_id'      => 'int',
        'product_id'    => 'int',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('hegyd-ecommerce.tables.order_line');
        $this->order_class = config('hegyd-ecommerce.models.order');
        $this->product_class = config('hegyd-ecommerce.models.product');
    }

    public function product()
    {
        return $this->belongsTo($this->product_class);
    }

    public function order()
    {
        return $this->belongsTo($this->order_class);
    }

    public function getUnitPriceTtcAttribute()
    {
        return $this->unit_price_ht * (1 + ($this->vat_rate / 100));
    }
}
