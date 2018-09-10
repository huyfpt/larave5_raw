<?php namespace App\Http\Controllers\Extranet\Common;


use App\Http\Controllers\Extranet\AbstractExtranetController;
use App\Http\Controllers\Traits\Apiable;
use App\Repositories\Contracts\Common\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;

class NotificationsController extends AbstractExtranetController
{

    use Apiable;

    private $listPerPage = [50 => 50, 100 => 100, 150 => 150, 200 => 200];

    public function __construct(Request $request, UserRepositoryInterface $repository)
    {
        parent::__construct($request, $repository);
    }

    public function index()
    {
        $title = trans('notifications.title.index');

        $this->breadcrumbs->addCrumb(trans('app.dashboard'), '/');
        $this->breadcrumbs->addCrumb($title);

        $perPageSelected = $this->getRequest()->get('perPage', 50);
        $notification = auth()->user()->notifications()->orderBy('created_at', 'DESC')->get();

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageSearchResults = $notification->slice(($currentPage - 1) * $perPageSelected, $perPageSelected)->all();
        $notifications = new LengthAwarePaginator($currentPageSearchResults, count($notification), $perPageSelected, null, ['path' => 'notifications']);
        $notifications->appends(Input::except(array('page')));
        $arrayNbNotif = $this->listPerPage;

        return view('app.contents.extranet.notifications.index', compact('title', 'notifications', 'arrayNbNotif', 'perPageSelected'));
    }

    public function read($id)
    {
        $this->_getNotificationById($id)->markAsRead();

        return $this->_tableView();
    }

    public function readAll()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return $this->_tableView();
    }

    public function unread($id)
    {
        $this->_getNotificationById($id)->update(['read_at' => null]);

        return $this->_tableView();
    }

    public function counter()
    {
        if ( ! $this->getRequest()->ajax())
            abort(401);

        $hundred_class = false;
        $user_notifications = $this->repository->unreadNotifications(auth()->user());
        $user_notifications_count = auth()->user()->unreadNotifications->count();
        if ($user_notifications_count > 99)
        {
            $user_notifications_count = '99+';
            $hundred_class = true;
        }

        return view('app.includes.notifications.list', compact('user_notifications', 'user_notifications_count', 'hundred_class'))->render();
    }

    public function destroy($id)
    {
        $this->_getNotificationById($id)->delete();

        return $this->_tableView();
    }

    private function _tableView()
    {
        $notifications = auth()->user()->notifications()->orderBy('created_at', 'DESC')->get();

        return view('app.contents.extranet.notifications.includes.table', compact('notifications'));
    }

    public function _getNotificationById($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();

        if ( ! $notification)
            abort(404);

        return $notification;
    }
}