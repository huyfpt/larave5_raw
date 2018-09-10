<?php namespace Hegyd\eCommerce\Models\Traits;


trait eCommerce
{

    public function orders()
    {
        return $this->hasMany(config('hegyd-ecommerce.models.order'));
    }
}