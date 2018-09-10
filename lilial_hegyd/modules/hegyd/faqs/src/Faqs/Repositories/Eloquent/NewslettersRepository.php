<?php
namespace Hegyd\Faqs\Repositories\Eloquent;

use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryBuilder;
use Hegyd\Faqs\Repositories\Contracts\NewsletterRepositoryInterface;
use Illuminate\Support\Facades\App;

/**
 * Class NewslettersRepository
 * @package Hegyd\Faqs\Repositories\Eloquent
 */
class NewslettersRepository extends Repository implements NewsletterRepositoryInterface
{

    public function model()
    {
        return config('hegyd-faqs.models.newsletters');
    }

    /**
     * Get active faqs filtered by category id
     * @param $category_id
     * @param bool $count
     * @return mixed
     */
    public function getActiveByCategory($category_id, $count = false)
    {
        $faqs = $this->_getActive();
        $faqs->where('category_id', $category_id);

        $extranet_service = app(config('hegyd-faqs.services.extranet'));
        $role = $extranet_service->getRole();
        $role_id = null;

        if(!in_array($role->name, config('hegyd-faqs.administrators'))) {
            $role_id = $role->id;
            $more_datas = [];

            $more_datas = app(config('hegyd-faqs.filters.faqs'))->buildFilter($role, $more_datas);

            app(config('hegyd-faqs.filters.faqs'))->getAllFaqsQuery($faqs, $role_id, $more_datas);
        }


        if ($count) {
            return $faqs->count();
        }

        $faqs->orderBy('start_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->orderBy('name', 'desc');

        return $faqs->get();
    }

    /**
     * Get faqs filtered by category id
     * @param $category_id
     * @param bool $count
     * @return mixed
     */
    public function getByCategory($category_id, $count = false)
    {
        $class = $this->model();
        $faqs = $class::where('category_id', $category_id);

        if ($count)
            return $faqs->count();

        $faqs->orderBy('start_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->orderBy('name', 'desc');

        return $faqs->get();
    }

    public function getActiveForSlider($role, $more_datas)
    {
        $faqs = $this->_getActive();
        $faqs->where('display_on_slider', true);

        if(!in_array($role->name, config('hegyd-faqs.administrators')))
        {
            app(config('hegyd-faqs.filters.faqs'))->getAllFaqsQuery($faqs, $role->id, $more_datas);
        }

        return $faqs->get();
    }

    /**
     * Get active faqs query
     * @return QueryBuilder
     */
    private function _getActive()
    {
        $class = $this->model();
        $now = Carbon::now();
        $faqs = $class::join('faqs_categories', 'faqs_categories.id', '=', 'faqs.category_id')
            ->where('faqs_categories.active', true)
            ->where('faqs.active', true)
            ->where(function ($q) use ($now)
            {
                $q->whereNull('faqs.start_at')
                    ->orWhere('faqs.start_at', '<=', $now);
            })
            ->where(function ($q) use ($now)
            {
                $q->whereNull('faqs.end_at')
                    ->orWhere('faqs.end_at', '>=', $now);
            })
            ->select('faqs.*');

        return $faqs;
    }
}