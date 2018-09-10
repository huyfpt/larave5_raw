<?php namespace App\Http\Controllers\Admin\EAV;


use App\Http\Controllers\AbstractAppController;
use App\Http\Controllers\Admin\AbstractAdminController;
use App\Http\Controllers\Traits\Apiable;
use App\Repositories\Contracts\EAV\AttributeRepositoryInterface;
use App\Repositories\Contracts\EAV\AttributeValueRepositoryInterface;
use App\Services\EAV\AttributeService;
use App\Services\EAV\AttributeValueService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class AttributeValuesController extends AbstractAdminController
{

    public function __construct(Request $request, AttributeValueRepositoryInterface $repository)
    {
        parent::__construct($request, $repository);
    }

    protected function configure()
    {
        return [
            // the prefix for the view routing, lang and view
            'prefixes'         => [
                'route' => 'admin.eav.',
                'lang'  => 'eav.',
                'view'  => 'app.contents.admin.eav.values.',
                'acl'   => 'admin.eav.values.',
            ],
            // the field of the model that will be used for construct the edit view's title (breadcrumb, main title)
            'edit_object_name' => 'value',
            'select'           => ['id'],
            'columns'          => ['id'],
            'views'            => ['index' => 'index'],
        ];
    }

    protected function beforeCreate($data = [])
    {

        $service = new AttributeValueService($this->repository);

        $data = parent::beforeCreate($data);

        $attribute = app(AttributeRepositoryInterface::class)
            ->findOrFail($data['attribute_id']);

        // Auto generate a key using attribute nama and value name
        $data['key'] = $service->generateValueKey(
            $attribute->transEntity('label'),
            $attribute->transAttribute('label'),
            $data['value']
        );

        return $data;

    }

    protected function afterCreated(Model $model, $data = [])
    {

        $service = new AttributeValueService($this->repository);

        $model = parent::afterCreated($model, $data);

        // Update position of all others current attribute values
        $service->updateOthersAttributeValuesPosition($model);

        return $model;

    }


    protected function afterSave(Model $model, $data = [])
    {

        $model = parent::afterSave($model, $data);

        $attribute = $model->attribute;

        // Synchronise/save attached users if necessary an available
        if( $attribute->with_users ){
            $users_ids = (isset($data['users'])) ? $data['users'] : [];
            $model->users()->sync($users_ids);
        }

        // Synchronise/save attached roles if necessary an available
        if( $attribute->with_roles ){
            $roles_ids = (isset($data['roles'])) ? $data['roles'] : [];
            $model->roles()->sync($roles_ids);
        }

        return $model;

    }


    public function create()
    {
        if ( ! $this->acl('create') ){
            abort(401);
        }
        if ( ! $this->getRequest()->has('attribute_id') ){
            abort(404);
        }

        $attribute = app(AttributeRepositoryInterface::class)
            ->findBy('id', $this->getRequest()->get('attribute_id'));

        $title = $this->getTitle(null, $attribute->transAttribute('label'));

        if ( ! $this->getRequest()->ajax()){
            $this->createFormBreadCrumb($title);
        }

        $model = $this->getRepository()->getModel();
        $route = $this->routeAlias('store');
        $view = $this->getConfig('views.create');
        $creationMode = true;

        return $this->displayFormView(
            $view, $title, $model, $route, 'post', compact('attribute', 'creationMode')
        );

    }




    /**
     * create the view's title, depending of the user model (null => new, !null => update)
     * @param BaseModel $model
     * @return string
     */
    protected function getTitle($model = null, $attributeName = null)
    {
        if ($model == null){
            return $this->trans('title.new', ['name' => $attributeName]);
        }

        return $this->trans('title.edit', ['name' => $model->{$this->getConfig('edit_object_name')}]);
    }


    public function destroy($id)
    {

        if ( ! $this->acl('delete')){
            abort(401);
        }

        $value = $this->repository->findOrFail($id);

        /** TODO : Check if value has some usage. If yes, then do not destroy it */
        if ($value->canDelete())
        {

            $value->delete();
            return $this->successJsonResponse(
                Response::HTTP_OK,
                [
                    'message' => trans('eav.labels.deleted'),
                    'value_id' => $value->id
                ]
            );
        }

        abort(403);

    }

    public function move()
    {

        if ( ! $this->acl('edit')){
            abort(401);
        }

        if (
            $this->getRequest()->has('attribute_id')
            && $this->getRequest()->has('new_order')
        ){

            $service = new AttributeValueService($this->repository);

            $attribute = app(AttributeRepositoryInterface::class)
                ->findOrFail($this->getRequest()->get('attribute_id'));

            $newOrder = $this->getRequest()->get('new_order');

            // Update position of all others current attribute values
            $service->updateAttributeValuesOrder($attribute, $newOrder);

            return $this->successJsonResponse(
                Response::HTTP_OK, ['message' => trans('eav.labels.moved')]
            );

        }

    }

    /**
     *
     * @param array $datas
     * @param object $model
     * @param string $routePrefix
     */
    protected function customRedirect(array $datas, $model, $routePrefix)
    {

        //dd($datas, $model, $routePrefix);

        /*$_action = null;
        if ( ! empty($datas['_action'])){
            $_action = $datas['_action'];
        }

        if (array_key_exists('save-and-close', $datas) || $_action == 'save-and-close'){
            return redirect()->route($routePrefix . 'index')->with('success_action', trans('app.success_action'));
        }

        if (array_key_exists('save-and-new', $datas) || $_action == 'save-and-new'){
            return redirect()->route($routePrefix . 'create')->with('success_action', trans('app.success_action'));
        }*/

        /*return redirect()
            ->route($routePrefix . 'index')
            ->with('success_action', trans('app.success_action'))
            ->with('attribute_id', $model->id)
            ->with('values_list',
                view(
                    'app.contents.admin.eav.includes.values_list',
                    ['attribute' => $model->attribute]
                )
            );*/

        if ( isset($datas['_method']) && $datas['_method'] == 'PUT' ){
            // EDIT MODE
            $message = trans('eav.labels.updated');
        } else {
            // ADD MODE
            $message = trans('eav.labels.added');
        }

        // Generate updated values lists
        $valuesList = view(
            'app.contents.admin.eav.includes.values_list',
            ['attribute' => $model->attribute]
        )->render();

        return $this->successJsonResponse(
            Response::HTTP_OK,
            [
                'message'       =>$message,
                'attribute_id'  => $model->attribute_id,
                'values_list'   => $valuesList,
            ]
        );

    }

}