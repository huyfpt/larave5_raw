<?php namespace Hegyd\Seos\Repositories\Eloquent;

use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryBuilder;
use Hegyd\Seos\Repositories\Contracts\SeosRepositoryInterface;
use Illuminate\Support\Facades\App;

/**
 * Class SeosRepository
 * @package Hegyd\Seos\Repositories\Eloquent
 */
class SeosRepository extends Repository implements SeosRepositoryInterface
{

    public function model()
    {
        return config('hegyd-seos.models.seos');
    }

    /**
     * Get active seos query
     * @return QueryBuilder
     */
    private function _getActive()
    {
        $class = $this->model();
        $now = Carbon::now();
        $seos = $class::all();

        return $seos;
    }
}