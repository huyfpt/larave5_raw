<?php namespace Hegyd\Pages\Repositories\Eloquent;

use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryBuilder;
use Hegyd\Pages\Repositories\Contracts\PagesRepositoryInterface;
use Illuminate\Support\Facades\App;

/**
 * Class PagesRepository
 * @package Hegyd\Pages\Repositories\Eloquent
 */
class PagesRepository extends Repository implements PagesRepositoryInterface
{

    public function model()
    {
        return config('hegyd-pages.models.pages');
    }

    /**
     * Get active pages query
     * @return QueryBuilder
     */
    private function _getActive()
    {
        $class = $this->model();
        $now = Carbon::now();
        $pages = $class::all();

        return $pages;
    }
}