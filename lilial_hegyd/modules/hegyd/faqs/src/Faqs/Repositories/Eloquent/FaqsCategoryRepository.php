<?php
namespace Hegyd\Faqs\Repositories\Eloquent;


use Hegyd\Faqs\Repositories\Contracts\FaqsCategoryRepositoryInterface;

/**
 * Class FaqsCategoryRepository
 * @package Hegyd\Faqs\Repositories\Eloquent
 */
class FaqsCategoryRepository extends Repository implements FaqsCategoryRepositoryInterface
{

    public function model()
    {
        return config('hegyd-faqs.models.faqs_category');
    }

    public function active($limit = 5)
    {
        $class = $this->model();

        return $class::where('status', 1)
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
    }


    /**
     * Check if the model can be deleted or not
     * @param $model
     * @param array $errors
     * @return boolean true if the deletion is possible else false (and the $errors whill be filled with the errors)
     */
    function checkDelete($model, array &$errors)
    {
        if ($model->faqs->count())
            return false;

        if($model->parent_id > 0)
            return false;
        return true;
    }

    public function ajaxCategories($params, $limit = 5)
    {
        $class = $this->model();
        if ($params == '' && isset($params)) {
            
        }
        return $class::where('status', $is_active)
                ->orderBy($order_by)
                ->limit($limit)
                ->get();
    }
}