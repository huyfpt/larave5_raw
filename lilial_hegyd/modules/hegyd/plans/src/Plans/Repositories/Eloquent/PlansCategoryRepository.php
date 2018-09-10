<?php namespace Hegyd\Plans\Repositories\Eloquent;


use Hegyd\Plans\Repositories\Contracts\PlansCategoryRepositoryInterface;

/**
 * Class PlansCategoryRepository
 * @package Hegyd\Plans\Repositories\Eloquent
 */
class PlansCategoryRepository extends Repository implements PlansCategoryRepositoryInterface
{

    public function model()
    {
        return config('hegyd-plans.models.plans_category');
    }

    public function active($is_active = true, $order_by = 'name')
    {
        $class = $this->model();

        return $class::where('active', $is_active)->orderBy($order_by)->get();
    }


    /**
     * Check if the model can be deleted or not
     * @param $model
     * @param array $errors
     * @return boolean true if the deletion is possible else false (and the $errors whill be filled with the errors)
     */
    function checkDelete($model, array &$errors)
    {
        if ($model->plans->count())
            return false;

        return true;
    }
}