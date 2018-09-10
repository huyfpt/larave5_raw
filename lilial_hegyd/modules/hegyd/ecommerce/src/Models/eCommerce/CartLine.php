<?php namespace Hegyd\eCommerce\Models\eCommerce;

use Illuminate\Database\Eloquent\Model;

/**
 * Hegyd\eCommerce\Models\eCommerce\CartLine
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Hegyd\eCommerce\Models\eCommerce\CartLine whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hegyd\eCommerce\Models\eCommerce\CartLine whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Hegyd\eCommerce\Models\eCommerce\CartLine whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CartLine extends Model
{
    private $product_class;
    private $cart_class;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('hegyd-ecommerce.tables.cart_line');
        $this->cart_class = config('hegyd-ecommerce.models.cart');
        $this->product_class = config('hegyd-ecommerce.models.product');
    }

    public function product()
    {
        return $this->belongsTo($this->product_class);
    }

    public function cart()
    {
        return $this->belongsTo($this->cart_class);
    }

    public function weight()
    {
        return $this->product->weight * $this->quantity;
    }
}
