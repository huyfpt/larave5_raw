<?php namespace Hegyd\eCommerce\Http\Controllers;

use Hegyd\eCommerce\Http\Controllers\Traits\Breadcrumbable;
use Hegyd\eCommerce\Services\Common\NotificationService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class AbstractController
 * @package Hegyd\eCommerce\Controllers
 */
abstract class AbstractController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    use Breadcrumbable;

    /** @var Illuminate\Http\Request current Request */
    protected $_request;

    /** @var RepositoryInterface current Model Repository */
    protected $repository;

    /**
     *
     * @var NotificationService
     */
    protected $notificationService;

    /**
     * - save the $request in this->_request
     * - initialize the Breadcrumb using Breadcrumbable
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->_request = $request;
        if ( ! $this->_request->ajax())
        {
            $this->includeBreadcrumbs();
        }
        $this->notificationService = App::make(NotificationService::class);
    }

    /**
     * Configure Breadcrumb
     *
     * @return array
     */
    protected function configureBreadcrumb()
    {
        return [
            'namespace'   => '',
            'cssClass'    => 'breadcrumb',
            'divider'     => '',
            'listElement' => 'ol'
        ];
    }

    protected function getRequest()
    {
        return $this->_request;
    }


    protected function getNotificationService()
    {
        return $this->notificationService;
    }

    /**
     * Check that url is correct
     * If it does, then return false
     * If it doesn't, then return a redirector to redirect to appropriate URL
     * @param $request
     * @param $entity
     * @return bool|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    protected function unvalidateUrlThenRedirect(Model $entity, $params = [])
    {
        if (method_exists($entity, 'url') && $entity->url() !== $this->getRequest()->url())
        {
            $url = $entity->url();
            if (count($params))
            {
                $url .= '?';
                $url .= implode('&', $params);
            }

            return redirect($url, '301');
        }

        return false;

    }
}
