<?php namespace Hegyd\Pages\Repositories\Contracts;

/**
 * Interface PagesRepositoryInterface
 * @package Hegyd\Pages\Repositories\Contracts
 */
interface PagesRepositoryInterface
{

    /**
     * Get active pages filtered by category id
     * @param $category_id
     * @param bool $count
     * @return mixed
     */
    // public function getActiveByCategory($category_id, $count = false);

    /**
     *
     * Get pages filtered by category id
     * @param $category_id
     * @param bool $count
     * @return mixed
     */
    // public function getByCategory($category_id, $count = false);

    /**
     * Get active pages to display on slider
     * @return mixed
     */
    // public function getActiveForSlider($role_id, $more_datas);
}
