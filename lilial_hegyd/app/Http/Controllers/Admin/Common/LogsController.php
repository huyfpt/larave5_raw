<?php
namespace App\Http\Controllers\Admin\Common;

use App\Http\Controllers\Traits\Breadcrumbable;
use \Hegyd\Logs\Controllers\LogsController as Controller;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    use Breadcrumbable;

    public function index(Request $request)
    {
        $view = parent::index($request);

        if($request->ajax())
            return $view;

        $this->includeBreadcrumbs();

        $this->breadcrumbs->addCrumb(trans('app.dashboard'), route('index'));
        $title = trans('hegyd-logs::logs.title.logs');
        $this->breadcrumbs->addCrumb($title, config('hegyd-logs.routes.index'));

        return $view->with('title', $title)->with('breadcrumb', $this->breadcrumbs);
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
}