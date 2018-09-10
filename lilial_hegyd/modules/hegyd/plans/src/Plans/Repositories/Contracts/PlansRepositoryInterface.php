<?php namespace Hegyd\Plans\Repositories\Contracts;

/**
 * Interface PlansRepositoryInterface
 * @package Hegyd\Plans\Repositories\Contracts
 */
interface PlansRepositoryInterface
{
    /**
     * Get active plans filtered by category id
     * @param $category_id
     * @param bool $count
     * @return mixed
     */
    public function getActiveByCategory($category_id, $count = false);

    /**
     *
     * Get plans filtered by category id
     * @param $category_id
     * @param bool $count
     * @return mixed
     */
    public function getByCategory($category_id, $count = false);

    /**
     * Get active plans to display on slider
     * @return mixed
     */
    public function getActiveForSlider($role_id, $more_datas);

    /**
     * get recent plans for home page
     * @return mixed
     */
    public function getRecentPlans();
}
