<?php namespace Hegyd\Plans\Repositories\Contracts;

use Hegyd\Plans\Models\PlansCategory;

/**
 * Interface PlansCategoryRepositoryInterface
 * @package Hegyd\Plans\Repositories\Contracts
 */
interface PlansCategoryRepositoryInterface
{

    public function active($is_active = true);
}
