<?php
namespace Hegyd\Faqs\Repositories\Eloquent;

use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryBuilder;
use Hegyd\Faqs\Repositories\Contracts\FaqsRepositoryInterface;
use Illuminate\Support\Facades\App;

/**
 * Class FaqsRepository
 * @package Hegyd\Faqs\Repositories\Eloquent
 */
class FaqsRepository extends Repository implements FaqsRepositoryInterface
{

    public function model()
    {
        return config('hegyd-faqs.models.faqs');
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
    public function getByCategory($category_id)
    {
        $class = $this->model();
        $category_id = intval($category_id);
        $now = Carbon::now();
        if ($category_id == 0) {
            return $class::where('status', 1)
                    ->where(function ($q) use ($now) {
                        $q->whereNull('faqs.start_at')
                            ->orWhere('faqs.start_at', '<=', $now);
                    })
                    ->where(function ($q) use ($now) {
                        $q->whereNull('faqs.end_at')
                            ->orWhere('faqs.end_at', '>=', $now);
                    })
                    ->orderBy('faqs.start_at', 'desc')
                    ->paginate(12);
        }
        
        $faqs = $class::where('category_id', $category_id)
                    ->where(function ($q) use ($now) {
                        $q->whereNull('start_at')
                          ->orWhere('start_at', '<=', $now);
                    })
                    ->where(function ($q) use ($now) {
                        $q->whereNull('end_at')
                          ->orWhere('end_at', '>=', $now);
                    })
                    ->where('status', 1)
                    ->orderBy('start_at', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->orderBy('title', 'desc')
                    ->paginate(12)->appends('category_id', $category_id);

        return $faqs;
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
            ->where('faqs_categories.status', true)
            ->where('faqs.status', true)
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

    /**
     * ajax search list FAQ
     * @param  integer $id      [description]
     * @param  string  $keyword [description]
     * @return [type]           [description]
     */
    public function ajaxListFaq($id = 0, $keyword = '')
    {

        $class = $this->model();

        $query = $class::select('faqs.id', 'faqs.title as text')
            ->join('faqs_categories', 'faqs_categories.id', '=', 'faqs.category_id');

        if (!empty($id)) {
            $query->where("faqs.id", '!=', $id);
        }

        if (!empty($keyword)) {
            $query->where("faqs.title", 'LIKE', '%'.$keyword.'%');
        }

        $faqs = $query->limit(20)->get(['id', 'title']);

        return $faqs;
    }

    public function active($request, $is_active = true, $order_by = 'title')
    {
        $class = $this->model();
        $now = Carbon::now();
        if ($request->category_id) {
            $id = $request->category_id;

            $faqs =  $class::where('status', $is_active)
                    ->where('faqs.category_id', '=', $id)
                    ->where(function ($q) use ($now) {
                        $q->whereNull('faqs.start_at')
                          ->orWhere('faqs.start_at', '<=', $now);
                    })
                    ->where(function ($q) use ($now) {
                        $q->whereNull('faqs.end_at')
                          ->orWhere('faqs.end_at', '>=', $now);
                    })
                    ->orderBy('faqs.start_at', 'desc')
                    ->paginate(12)->appends('category_id', $id);
        } else {
            $faqs =  $class::where('status', $is_active)
                    ->where(function ($q) use ($now) {
                        $q->whereNull('faqs.start_at')
                            ->orWhere('faqs.start_at', '<=', $now);
                    })
                    ->where(function ($q) use ($now) {
                        $q->whereNull('faqs.end_at')
                            ->orWhere('faqs.end_at', '>=', $now);
                    })
                    ->orderBy('faqs.start_at', 'desc')
                    ->paginate(12);
        }
        
        return $faqs;
    }

    public function getFaqBySlug($request)
    {
        $class = $this->model();

        if ($request->slug) {
            $faq = $class::where('slug', $request->slug);
        }

        return $faq->first();
    }

}