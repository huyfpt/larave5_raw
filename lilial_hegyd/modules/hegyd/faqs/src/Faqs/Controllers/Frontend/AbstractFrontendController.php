<?php
namespace Hegyd\Faqs\Controllers\Frontend;

use Hegyd\Faqs\Controllers\AbstractController;
use Hegyd\Faqs\Controllers\Traits\Apiable;
use Hegyd\Faqs\Controllers\Traits\Configurable;
use Hegyd\Faqs\Controllers\Traits\Datatable;
use Hegyd\Faqs\Controllers\Traits\Formable;
use Hegyd\Faqs\Repositories\Contracts\RepositoryInterface;
use Illuminate\Http\Request;

/**
 * Class AbstractFrontendController
 * @package Hegyd\Faqs\Controllers\Frontend
 */
abstract class AbstractFrontendController extends AbstractController
{
    use Configurable, Apiable;

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
        $config['namespace'] = config('hegyd-faqs.view-namespace.frontend');

        return $config;
    }

    protected function getRepository()
    {
        return $this->repository;
    }
}