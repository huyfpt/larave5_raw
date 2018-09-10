<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Notification\NotificationService;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\Breadcrumbable;
use Illuminate\Support\Facades\App;

abstract class AbstractAppController extends Controller
{

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
        $this->notificationService = app(NotificationService::class);
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

    protected function getNotificationService()
    {
        return $this->notificationService;
    }

    protected function getRepository()
    {
        return $this->repository;
    }

    protected function getRequest()
    {
        return $this->_request;
    }
}
