<?php

namespace App\Http\Controllers\Frontend\Common;

use App\Http\Controllers\Admin\AbstractAdminController;
use App\Http\Controllers\Extranet\AbstractExtranetController;
use App\Http\Controllers\Traits\Apiable;
use App\Http\Controllers\Traits\Configurable;
use App\Http\Controllers\Traits\Formable;
use App\Http\Controllers\Traits\Uploadable;
use App\Repositories\Contracts\ACL\RoleRepositoryInterface;
use App\Repositories\Contracts\Sale\LevelRepositoryInterface;
use App\Services\Notification\NotificationService;
use App\Repositories\Contracts\Common\UserRepositoryInterface;
use Hegyd\Uploads\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Traits\Addressable;


class ProfileController extends AbstractExtranetController
{

    use Addressable, Uploadable, Formable, Configurable, Apiable;

    public function __construct(Request $request, UserRepositoryInterface $repository)
    {
        parent::__construct($request, $repository);
    }

    /**
     * configure the view
     * @return  array
     */
    protected function configure()
    {
        return [
            // the prefix for the view routing, lang and view
            'prefixes' => [
                'route' => 'extranet.users.',
                'lang'  => 'users.',
                'view'  => 'app.contents.extranet.users.',
                'acl'   => 'extranet.profile',
            ],
        ];
    }

    public function configureAddresses()
    {
        return ['address' => []];
    }

    public function configureUploads()
    {
        return [
            'visual' => [
                'type'       => 'image',
                'relation'   => Upload::RELATION_UNIQUE,
                'visibility' => Upload::VISIBILITY_PUBLIC,
            ]
        ];
    }

    public function myProfile()
    {
        $user = auth()->user();

        if ( ! $user->can('extranet.profile.show'))
            abort(401);

        $this->breadcrumbs->addCrumb(trans('app.dashboard'), route('index'));

        $title = trans('app.my_personal_informations');
        $this->breadcrumbs->addCrumb($title);

        return view('front.profile.profile', compact('title', 'user'));
    }

    public function myProfileUpdate()
    {
        $user = auth()->user();

        if ( ! $user->can('extranet.profile.edit'))
            abort(401);

        // Save infos updatable by user
        $this->getRepository()->setMyModel($user);
        $datas = $this->getRequest()->all();

        //newsletter
        $datas['newsletter'] = $datas['newsletter'] == 'on' ? 1 : 0;

        // dd($datas);

        $validator = $this->validation($datas);
        if ($validator->fails())
        {
            $noti = trans('users.labels.cannot_save');
            return $this->redirectError(route('frontend.homes.profile'), $validator)->with('message', $noti);;
        } else
        {
            $datas = $this->beforeUpdate($user, $datas);
            $datas = $this->beforeSave($datas, $user);
            $user = $this->updateExisting($datas, $user->id);
            $this->notifyUpdated(trans('users.labels.profile_updated'));

            $noti = trans('users.labels.profile_updated');

            return redirect()->route('frontend.homes.profile')->with('message', $noti);
        }
    }

    protected function redirectError($redirectUrl, $validator)
    {
        $this->getNotificationService()->flashNotify(trans('users.labels.cannot_save'), 'danger');

        $redirection = redirect($redirectUrl)->withErrors($validator);
        $excepts = $this->exeptInputs();
        if ( ! empty($excepts))
        {
            $redirection->withInput(\Input::except($excepts));
        } else
        {
            $redirection->withInput();
        }

        return $redirection;
    }

    protected function beforeSave(array $datas, Model $model = null)
    {

        if (isset($datas['password']) && $datas['password'])
        {
            $datas['password_clear'] = $datas['password'];
            $datas['password'] = bcrypt($datas['password']);
        } else
        {
            unset($datas['password']);
        }

        if(isset($datas['phone']))
        {
            $datas['phone'] = str_replace([' ', '-', '.'], '', str_replace('+33', '0', $datas['phone']));
        }

        return $datas;
    }

    public function show($id)
    {
        if ( ! $this->getRequest()->ajax())
            abort(401);

        return $this->repository->findOrFail($id);
    }

    public function showModal($id)
    {
        if ( ! $this->getRequest()->ajax())
            abort(401);

        $model = $this->repository->findOrFail($id);

        $title = trans('users.title.show', ['name' => $model->fullname()]);

        return view('app.contents.common.users.includes.modals.show', compact('model', 'title'));
    }

    public function search()
    {
        $term = $this->getRequest()->get('term');

        $users = $this->repository->search($term);

        return $this->successJsonResponse(Response::HTTP_OK, ['users' => $users]);
    }
}
