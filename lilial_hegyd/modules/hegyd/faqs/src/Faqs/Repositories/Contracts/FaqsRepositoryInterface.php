<?php
namespace Hegyd\Faqs\Repositories\Contracts;

/**
 * Interface FaqsRepositoryInterface
 * @package Hegyd\Faqs\Repositories\Contracts
 */
interface FaqsRepositoryInterface
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
     * Get faq filtered by category id
     * @param $category_id
     * @param bool $count
     * @return mixed
     */
    public function getByCategory($category_id);

    /**
     * Get active faqs to display on slider
     * @return mixed
     */
    public function getActiveForSlider($role_id, $more_datas);

    /**
     * Get all active faqs for list view
     * @param  boolean $is_active
     * @return mixed
     */
    public function active($request, $is_active = true);

    /**
     * Get all active faqs for list view
     * @param  boolean $is_active
     * @return mixed
     */
    public function getFaqBySlug($request);
}
