<?php namespace App\Http\Controllers\Extranet;

use App\Http\Controllers\AbstractAppController;
use App\Http\Controllers\Traits\Apiable;
use App\Http\Controllers\Traits\Formable;
use App\Http\Controllers\Traits\Configurable;
use App\Http\Controllers\Traits\Datatable;
use App\Services\Notification\NotificationService;
use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Http\Request;

abstract class AbstractExtranetController extends AbstractAppController
{
    /**
     *
     * @param Request $request
     * @param RepositoryInterface $repository
     */
    public function __construct(Request $request, RepositoryInterface $repository)
    {
        parent::__construct($request);
        $this->repository = $repository;
    }

    /**
     * Configure Breadcrumb
     *
     * @return array
     */
    protected function configureBreadcrumb()
    {
        $config = parent::configureBreadcrumb();
        $config['namespace'] = 'app';

        return $config;
    }
}