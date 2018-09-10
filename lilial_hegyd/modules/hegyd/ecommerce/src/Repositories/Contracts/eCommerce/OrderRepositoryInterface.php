<?php namespace Hegyd\eCommerce\Repositories\Contracts\eCommerce;

interface OrderRepositoryInterface
{

    public function countOnGoing($site = null);

    public function countBeforeValidated($site = null);

    public function users();

    public function statusByUser($user);
}