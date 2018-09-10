<?php namespace Hegyd\eCommerce\Http\Controllers\Frontend;

use Hegyd\eCommerce\Http\Controllers\AbstractController;
use Hegyd\eCommerce\Http\Controllers\Traits\Configurable;
use Hegyd\eCommerce\Http\Controllers\Traits\Datatable;
use Hegyd\eCommerce\Http\Controllers\Traits\Formable;
use Hegyd\eCommerce\Repositories\Contracts\RepositoryInterface;
use Illuminate\Http\Request;

/**
 * Class AbstractFrontendController
 * @package Hegyd\eCommerce\Http\Controllers\Frontend
 */
abstract class AbstractFrontendController extends AbstractController
{
    use Configurable;

    /**
     *
     * @param Request $request
     * @param RepositoryInterface $repository
     */
    public function __construct(Request $request, RepositoryInterface $repository)
    {
        parent::__construct($request);
        $this->repository = $repository;
        $this->createConfiguration();
    }

    /**
     * Configure Breadcrumb
     *
     * @return array
     */
    protected function configureBreadcrumb()
    {
        $config = parent::configureBreadcrumb();
        $config['namespace'] = config('hegyd-ecommerce.view-namespace.frontend');

        return $config;
    }

    protected function getRepository()
    {
        return $this->repository;
    }
}