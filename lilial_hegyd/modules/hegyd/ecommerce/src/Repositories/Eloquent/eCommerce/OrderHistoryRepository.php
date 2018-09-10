<?php namespace Hegyd\eCommerce\Repositories\Eloquent\eCommerce;


use Hegyd\eCommerce\Models\eCommerce\OrderHistory;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\OrderHistoryRepositoryInterface;
use Hegyd\eCommerce\Repositories\Eloquent\Repository;

class OrderHistoryRepository extends Repository implements OrderHistoryRepositoryInterface
{

    public function model()
    {
        return OrderHistory::class;
    }
}