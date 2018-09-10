<?php namespace Hegyd\eCommerce\Models\eCommerce;


use Hegyd\eCommerce\Models\AbstractModel;

class OrderHistory extends AbstractModel
{

    private $user_class;
    private $order_class;

    protected $fillable = [
        'text',
        'user_id',
        'order_id',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('hegyd-ecommerce.tables.order_history');
        $this->order_class = config('hegyd-ecommerce.models.order');
        $this->user_class = config('hegyd-ecommerce.models.user');
    }

    public function user()
    {
        return $this->belongsTo($this->user_class);
    }

    public function order()
    {
        return $this->belongsTo($this->order_class);
    }
}