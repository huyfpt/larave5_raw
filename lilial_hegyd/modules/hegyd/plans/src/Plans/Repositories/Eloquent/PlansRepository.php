<?php namespace Hegyd\Plans\Repositories\Eloquent;

use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryBuilder;
use Hegyd\Plans\Repositories\Contracts\PlansRepositoryInterface;
use Illuminate\Support\Facades\App;
use App\Models\Common\City;

/**
 * Class PlansRepository
 * @package Hegyd\Plans\Repositories\Eloquent
 */
class PlansRepository extends Repository implements PlansRepositoryInterface
{

    public function model()
    {
        return config('hegyd-plans.models.plans');
    }

    /**
     * Get active plans filtered by category id
     * @param $category_id
     * @param bool $count
     * @return mixed
     */
    public function getActiveByCategory($category_id, $count = false)
    {
        $plans = $this->_getActive();
        $plans->where('category_id', $category_id);

        $extranet_service = app(config('hegyd-plans.services.extranet'));
        $role = $extranet_service->getRole();
        $role_id = null;

        if(!in_array($role->name, config('hegyd-plans.administrators'))) {
            $role_id = $role->id;
            $more_datas = [];

            $more_datas = app(config('hegyd-plans.filters.plans'))->buildFilter($role, $more_datas);

            app(config('hegyd-plans.filters.plans'))->getAllplansQuery($plans, $role_id, $more_datas);
        }


        if ($count) {
            return $plans->count();
        }

        $plans->orderBy('start_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->orderBy('name', 'desc');

        return $plans->get();
    }

    /**
     * Get plans filtered by category id
     * @param $category_id
     * @param bool $count
     * @return mixed
     */
    public function getByCategory($category_id, $count = false)
    {
        $class = $this->model();
        $plans = $class::where('category_id', $category_id);

        if ($count)
            return $plans->count();

        $plans->orderBy('start_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->orderBy('name', 'desc');

        return $plans->get();
    }

    public function getActiveForSlider($role, $more_datas)
    {
        $plans = $this->_getActive();
        $plans->where('display_on_slider', true);

        if(!in_array($role->name, config('hegyd-plans.administrators')))
        {
            app(config('hegyd-plans.filters.plans'))->getAllplansQuery($plans, $role->id, $more_datas);
        }

        return $plans->get();
    }

    /**
     * Get active plans query
     * @return QueryBuilder
     */
    private function _getActive()
    {
        $class = $this->model();
        $now = Carbon::now();
        $plans = $class::join('plans_categories', 'plans_categories.id', '=', 'plans.category_id')
            ->where('plans_categories.active', true)
            ->where('plans.active', true)
            ->where(function ($q) use ($now)
            {
                $q->whereNull('plans.start_at')
                    ->orWhere('plans.start_at', '<=', $now);
            })
            ->where(function ($q) use ($now)
            {
                $q->whereNull('plans.end_at')
                    ->orWhere('plans.end_at', '>=', $now);
            })
            ->select('plans.*');

        return $plans;
    }

    public function getRecentPlans($limit = 3)
    {
        $plans = $this->_getActive()
                      ->where('avantage', true)
                      ->where('visibility', true)
                      ->where('start_at', '<=', Carbon::now())
                      ->where('end_at', '>=', Carbon::now());
        $plans->orderBy('created_at', 'desc')
            ->limit($limit);

        return $plans->get();
    }
}