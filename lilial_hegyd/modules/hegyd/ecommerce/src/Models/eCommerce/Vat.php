<?php namespace Hegyd\eCommerce\Models\eCommerce;


use Hegyd\eCommerce\Models\AbstractModel;

class Vat extends AbstractModel
{
    protected $fillable = [
        'name',
        'rate',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('hegyd-ecommerce.tables.vat');
    }


}