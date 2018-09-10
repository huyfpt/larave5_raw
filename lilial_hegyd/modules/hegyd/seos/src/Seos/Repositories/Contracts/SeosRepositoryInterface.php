<?php namespace Hegyd\Seos\Repositories\Contracts;

/**
 * Interface SeosRepositoryInterface
 * @package Hegyd\Seos\Repositories\Contracts
 */
interface SeosRepositoryInterface
{

    /**
     * Get active Seos filtered by category id
     * @param $category_id
     * @param bool $count
     * @return mixed
     */
    // public function getActiveByCategory($category_id, $count = false);

    /**
     *
     * Get Seos filtered by category id
     * @param $category_id
     * @param bool $count
     * @return mixed
     */
    // public function getByCategory($category_id, $count = false);

    /**
     * Get active Seos to display on slider
     * @return mixed
     */
    // public function getActiveForSlider($role_id, $more_datas);
}
