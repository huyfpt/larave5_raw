<?php namespace Hegyd\Seos\Controllers\Traits;


use Hegyd\Uploads\Controllers\Traits\Uploadable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\FacadesInput;

trait Formable
{

    /** @var Model the current model if we are on edit view, else null */
    protected $model;

    /**
     * the name of the fields to excepts when redisplaying the form after errors
     * @return array
     */
    protected function exeptInputs()
    {
        return [];
    }

    protected abstract function getRequest();

    protected abstract function getRepository();

    protected abstract function getNotificationService();

    /**
     *
     * @param array $datas
     * @param object $model
     * @param string $routePrefix
     */
    protected function customRedirect(array $datas, $model, $routePrefix)
    {
        $_action = null;
        if ( ! empty($datas['_action']))
        {
            $_action = $datas['_action'];
        }
        if (array_key_exists('save-and-close', $datas) || $_action == 'save-and-close')
        {
            return redirect()->route($routePrefix . 'index')->with('success_action', trans('app.success_action'));
        }
        if (array_key_exists('save-and-new', $datas) || $_action == 'save-and-new')
        {
            return redirect()->route($routePrefix . 'create')->with('success_action', trans('app.success_action'));
        }

        return redirect()->route($routePrefix . 'edit', ['id' => $model->id])->with('success_action', trans('app.success_action'));
    }

    /**
     *
     * @param string $messsage
     */
    protected function notifyCreated($messsage)
    {
        $this->getNotificationService()->flashNotify($messsage, 'success');
    }

    /**
     *
     * @param string $messsage
     */
    protected function notifyUpdated($messsage)
    {
        $this->getNotificationService()->flashNotify($messsage, 'success');
    }

    /**
     *
     * @param string $messsage
     */
    protected function notifyError($messsage)
    {
        $this->getNotificationService()->flashNotify($messsage, 'danger');
    }

    /**
     * create the view's title, depending of the user model (null => new, !null => update)
     * @param BaseModel $model
     * @return string
     */
    protected function getTitle($model = null)
    {
        if ($model == null)
        {
            return $this->trans('title.new');
        }

        return $this->trans('title.edit', ['name' => $model->{$this->getConfig('edit_object_name')}]);
    }

    /**
     * For the edit view or the create view
     * Fill the breadcrumbs created in AbstractAppController
     * with the use of the instance of Breadcrumb defined by the Trait Breadcrumbable
     * @param String $title : the view title
     * @param BaseModel $model
     * @use creitive/laravel5-breadcrumbs vendor
     */
    protected function createFormBreadCrumb($title, $model = null)
    {
        $this->breadcrumbs->addCrumb(trans('app.dashboard'), route('index'));
        $this->breadcrumbs->addCrumb($this->trans('title.management'), $this->route('index'));
        $this->breadcrumbs->addCrumb($title);
    }

    /**
     *
     * @param string $title
     * @param object $model
     * @param string $route
     * @param string $method
     * @return Response
     */
    protected function displayFormView($view, $title, $model, $route, $method, $viewVars = [])
    {
        $this->getRepository()->setMyModel($model);
        // we gets the view
        $view = $this->view($view, compact('title', 'model', 'route', 'method'));
        // we gets the variables to inject into the view
        $vars = $viewVars;
        $vars += $this->viewVars($model);
        if ( ! empty($vars))
        {
            foreach ($vars as $name => $value)
            {
                $view->with($name, $value);
            }
        }

        return $view;
    }

    /**
     * Handle create request.
     *
     * @return Response
     */
    public function create()
    {
        if ( ! $this->acl('create'))
        {
            abort(401);
        }
        $title = $this->getTitle();

        if ( ! $this->getRequest()->ajax())
        {
            $this->createFormBreadCrumb($title);
        }

        $model = $this->getRepository()->getModel();
        $route = $this->routeAlias('store');
        $view = $this->getConfig('views.create');

        return $this->displayFormView($view, $title, $model, $route, 'post');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        if ( ! $this->acl('create'))
        {
            abort(401);
        }
        $datas = $this->beforeValidate(Input::all());
        $validator = $this->validation($datas);
        if ($validator->fails())
        {
            return $this->redirectError($this->route('create'), $validator);
        } else
        {
            $datas = $this->beforeCreate($datas);
            $datas = $this->beforeSave($datas);
            $model = $this->storeNew($datas);
            $this->notifyCreated($this->trans('label.new_created'));

            return $this->customRedirect($datas, $model, $this->prefix('route'));
        }
    }

    /**
     * Handle edit request.
     * @param interger $id => the id to edit
     * @return Response
     */
    public function edit($id)
    {
        if ( ! $this->acl('edit'))
        {
            abort(401);
        }

        $this->model = $this->getRepository()->find($id);
        if ($this->model == null)
        {
            $this->notifyError($this->trans('label.not_found'));

            return redirect()->route($this->routeAlias('index'));
        }
        $this->model = $this->beforeDisplay($this->model);

        $title = $this->getTitle($this->model);

        if ( ! $this->getRequest()->ajax())
        {
            $this->createFormBreadCrumb($title, $this->model);
        }

        $route = $this->routeAlias('update', ['id' => $this->model->id]);
        $route = [$route, $this->model->id];
        $view = $this->getConfig('views.update');

        return $this->displayFormView($view, $title, $this->model, $route, 'put');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        if ( ! $this->acl('edit'))
        {
            abort(401);
        }

        $this->model = $this->getRepository()->find($id);
        if ($this->model == null)
        {
            $this->notifyError($this->trans('label.not_found'));

            return redirect()->route($this->routeAlias('index'));
        }

        $this->getRepository()->setMyModel($this->model);
        $datas = $this->beforeValidate(Input::all());

        $validator = $this->validation($datas);
        if ($validator->fails())
        {
            return $this->redirectError($this->route('edit', $id), $validator);
        } else
        {
            $datas = $this->beforeUpdate($this->model, $datas);
            $datas = $this->beforeSave($datas, $this->model);
            $this->model = $this->updateExisting($datas, $id);
            $this->notifyUpdated($this->trans('label.updated'));

            return $this->customRedirect($datas, $this->model, $this->prefix('route'));
        }
    }

    /**
     * redirect to the url and notify
     * @param String $redirectUrl
     * @param Validator $validator
     * @return Response
     */
    protected function redirectError($redirectUrl, $validator)
    {
        $this->notifyError($this->trans('label.cannot_save'));

        $redirection = redirect($redirectUrl)->withErrors($validator);
        $excepts = $this->exeptInputs();
        if ( ! empty($excepts))
        {
            $redirection->withInput(Input::except($excepts));
        } else
        {
            $redirection->withInput();
        }

        return $redirection;
    }

    /**
     * check of the class of the current instance use the trait corresponding to $trait
     * check in package App\Http\Controllers\Traits\
     * @param string $trait
     * @return boolean
     */
    protected function hasTrait($trait_searched, $full_class = false)
    {
        $traits = [];

        $class = $this;

        do
        {
            $traits = array_merge(class_uses($class, true), $traits);
        } while ($class = get_parent_class($class));

        foreach ($traits as $trait => $same)
        {
            $traits = array_merge(class_uses($trait, true), $traits);
        }

        $traits = array_unique($traits);

        if ( ! $full_class)
            $trait_searched = 'App\Http\Controllers\Traits\\' . $trait_searched;

        return in_array($trait_searched, $traits);
    }
    /*
     * Operations on datas
     * Must be overriden if you want to define specifics actions on this opéretions
     *
     */

    /**
     * Validation.
     * @param array $datas
     * @return Validator
     */
    protected function validation(array $datas)
    {
        $validator = $this->getRepository()->validator($datas);
        if ($this->hasTrait(Uploadable::class, true))
        {
            $validator = $this->validateFiles($validator, $datas);
        }

        return $validator;
    }

    /**
     * called when the form is submited on an existing datas
     * @param array $datas
     * @param integer $id
     * @return the updated model
     */
    protected function updateExisting(array $datas, $id)
    {
        $this->getRepository()->updateRich($datas, $id);

        $model = $this->getRepository()->find($id);
        $model = $this->afterUpdated($model, $datas);
        $model = $this->afterSave($model, $datas);

        return $model;
    }

    /**
     * Store the the new data to DB
     * @param array $datas
     * @param String $visual
     */
    protected function storeNew(array $datas)
    {
        $this->getRepository()->save($datas);
        $model = $this->getRepository()->getModel();
        $model = $this->afterCreated($model, $datas);
        $model = $this->afterSave($model, $datas);

        return $model;
    }

    /**
     * Prepare datas using specific features from Traits
     * @param array $datas
     * @return array $datas updated
     */
    protected function beforeValidate(array $datas)
    {
        if ($this->hasTrait('Dateable'))
        {
            $datas = $this->saveDates($datas);
        }

        return $datas;
    }

    /**
     * Prepare datas for displaying the view using specific features from Traits
     * @param Model $model transformed
     * @return Model $model updated
     */
    protected function beforeDisplay(Model $model)
    {
        if ($this->hasTrait('Dateable'))
        {
            $model = $this->formatLocaleDates($model);
        }

        return $model;
    }

    /**
     * Called before the storeNew or updateExisting methods
     * Execute treatments on $datas array received from request
     * @param array $datas
     * @param Model $model
     * @return array $datas updated
     */
    protected function beforeSave(array $datas, Model $model = null)
    {
        if ($this->hasTrait('Editorable'))
        {
            $datas = $this->convertBase64($datas);
        }

        return $datas;
    }

    /**
     * Called after the storeNew or updateExisting methods
     * Execute treatments on $model after his save
     * @param object $model
     * @return object $model updated
     */
    protected function afterSave(Model $model, $data = [])
    {
        if ($this->hasTrait(Uploadable::class, true))
        {
            $model = $this->saveFiles($data, $model);
        }

        if ($this->hasTrait('Seoable'))
        {
            $model = $this->saveSeo($data, $model);
        }

        if ($this->hasTrait('Addressable'))
        {
            $model = $this->saveAddresses($data, $model);
        }

        return $model;
    }

    protected function beforeCreate($data = [])
    {
        return $data;
    }

    protected function beforeUpdate(Model $model, $data)
    {
        return $data;
    }

    protected function afterCreated(Model $model, $data = [])
    {
        return $model;
    }

    protected function afterUpdated(Model $model, $data)
    {
        return $model;
    }
}