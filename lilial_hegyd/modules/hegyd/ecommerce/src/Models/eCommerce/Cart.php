<?php namespace Hegyd\eCommerce\Models\eCommerce;

use Hegyd\eCommerce\Models\AbstractModel;

/**
 * Hegyd\eCommerce\Models\eCommerce\Cart
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Hegyd\eCommerce\Models\eCommerce\Cart whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hegyd\eCommerce\Models\eCommerce\Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Hegyd\eCommerce\Models\eCommerce\Cart whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Cart extends AbstractModel
{
    private $cart_line_class;
    private $user_class;
    private $address_class;

    protected $fillable = [
        'comment',
        'remember_token',
        'payment_means',
        'user_id',
        'invoice_address_id',
        'delivery_address_id',
        'payment_id',
    ];

    const ADDRESS_TYPE_DELIVERY = 1;
    const ADDRESS_TYPE_INVOICE = 2;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('hegyd-ecommerce.tables.cart');
        $this->cart_line_class = config('hegyd-ecommerce.models.cart_line');
        $this->user_class = config('hegyd-ecommerce.models.user');
        $this->address_class = config('hegyd-ecommerce.models.address');
    }

    public function lines()
    {
        return $this->hasMany($this->cart_line_class);
    }

    public function user()
    {
        return $this->belongsTo($this->user_class);
    }

    public function deliveryAddress()
    {
        return $this->belongsTo($this->address_class);
    }

    public function invoiceAddress()
    {
        return $this->belongsTo($this->address_class);
    }

    public function weight()
    {
        $weight = 0;

        foreach ($this->lines as $line)
        {
            $weight += $line->weight();
        }

        return $weight;
    }

    public function countProduct()
    {
        $count = 0;
        foreach ($this->lines as $line)
        {
            $count += $line->quantity;
        }

        return $count;
    }
}
