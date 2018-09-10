<?php namespace Hegyd\eCommerce\Models\eCommerce;

use Hegyd\eCommerce\Models\AbstractModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Hegyd\eCommerce\Models\eCommerce\Order
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Hegyd\eCommerce\Models\eCommerce\Order whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hegyd\eCommerce\Models\eCommerce\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Hegyd\eCommerce\Models\eCommerce\Order whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Order extends AbstractModel
{

    use SoftDeletes;

    private $user_class;
    private $order_line_class;
    private $order_history_class;

    protected $fillable = [
        'reference',
        'status',
        'delivery_firstname',
        'delivery_lastname',
        'delivery_company',
        'delivery_address',
        'delivery_additional_1',
        'delivery_zip',
        'delivery_city',
        'delivery_country',
        'delivery_phone',
        'delivery_email',
        'invoice_firstname',
        'invoice_lastname',
        'invoice_company',
        'invoice_address',
        'invoice_additional_1',
        'invoice_additional_2',
        'invoice_zip',
        'invoice_city',
        'invoice_country',
        'invoice_phone',
        'invoice_email',
        'weight_total',
        'product_total_ht',
        'product_total_ttc',
        'total_ht',
        'total_vat',
        'total_ttc',
        'delivery_price',
        'payment_means',
        'comment',
        'user_id',
        'paid_at',
        'payment_id',
    ];

    protected $casts = [
        'status'            => 'int',
        'product_total_ht'  => 'double',
        'product_total_ttc' => 'double',
        'total_ht'          => 'double',
        'total_vat'         => 'double',
        'total_ttc'         => 'double',
        'shipping_price'    => 'double',
        'user_id'           => 'int',
    ];

    protected $dates = [
        'paid_at',
    ];

    const STATUS_ERROR = 0;
    const STATUS_WAITING_FOR_PAYMENT = 10;
    const STATUS_CANCELLED = 20;
    const STATUS_PAID = 30;
    const STATUS_REFUND = 40;
    const STATUS_IN_PREPARATION = 50;
    const STATUS_TREATED = 60;
    const STATUS_SHIPPED = 70;
    const STATUS_DELIVERED = 80;
    const STATUS_ARCHIVED = 100;

    const PAYMENT_MEANS_CREDIT_CART = 1;
    const PAYMENT_MEANS_PAYPAL = 2;
    const PAYMENT_MEANS_ACCORDING_CONTRACT = 100;

    static public $status = [
        self::STATUS_ERROR               => 'orders.status.error',
        self::STATUS_WAITING_FOR_PAYMENT => 'orders.status.waiting_for_payment',
        self::STATUS_CANCELLED           => 'orders.status.cancelled',
        self::STATUS_PAID                => 'orders.status.paid',
        self::STATUS_REFUND              => 'orders.status.refund',
        self::STATUS_IN_PREPARATION      => 'orders.status.in_preparation',
        self::STATUS_TREATED             => 'orders.status.treated',
        self::STATUS_SHIPPED             => 'orders.status.shipped',
        self::STATUS_DELIVERED           => 'orders.status.delivered',
        self::STATUS_ARCHIVED            => 'orders.status.archived',
    ];

    static public $payment_means = [
        self::PAYMENT_MEANS_CREDIT_CART        => 'orders.payment_means.credit_cart',
        self::PAYMENT_MEANS_PAYPAL             => 'orders.payment_means.paypal',
        self::PAYMENT_MEANS_ACCORDING_CONTRACT => 'orders.payment_means.according_contract',
    ];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('hegyd-ecommerce.tables.order');
        $this->order_line_class = config('hegyd-ecommerce.models.order_line');
        $this->order_history_class = config('hegyd-ecommerce.models.order_history');
        $this->user_class = config('hegyd-ecommerce.models.user');
    }

    public function lines()
    {
        return $this->hasMany($this->order_line_class);
    }

    public function user()
    {
        return $this->belongsTo($this->user_class);
    }

    public function histories()
    {
        return $this->hasMany($this->order_history_class);
    }

    public function productsCount()
    {
        $count = 0;

        foreach ($this->lines as $line)
        {
            $count += $line->quantity;
        }

        return $count;
    }
}
