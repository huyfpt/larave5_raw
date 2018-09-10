<?php
namespace Hegyd\Faqs\Repositories\Contracts;

use Hegyd\Faqs\Models\FaqsCategory;

/**
 * Interface FaqsCategoryRepositoryInterface
 * @package Hegyd\Faqs\Repositories\Contracts
 */
interface FaqsCategoryRepositoryInterface
{

    public function active($limit = 5);
    
}
