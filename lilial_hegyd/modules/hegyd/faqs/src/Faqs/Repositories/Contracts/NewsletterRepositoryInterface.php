<?php
namespace Hegyd\Faqs\Repositories\Contracts;

/**
 * Interface FaqsRepositoryInterface
 * @package Hegyd\Faqs\Repositories\Contracts
 */
interface NewsletterRepositoryInterface
{

    /**
     * Get active news filtered by category id
     * @param $category_id
     * @param bool $count
     * @return mixed
     */
    public function getActiveByCategory($category_id, $count = false);

    /**
     *
     * Get news filtered by category id
     * @param $category_id
     * @param bool $count
     * @return mixed
     */
    public function getByCategory($category_id, $count = false);

    /**
     * Get active news to display on slider
     * @return mixed
     */
    public function getActiveForSlider($role_id, $more_datas);
}
