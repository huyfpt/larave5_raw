<?php

namespace App\Http\Controllers\Traits;

use App\Facades\AppTools;
use App\Models\AbstractModel;
use Barryvdh\Debugbar\Facade;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Excel;
use Hegyd\News\Models\AbstractModel as AbstractNewsModel;
use App\Models\Common\User;
use App\Models\Common\Client;

trait Datatable
{

    /** @var Array */
    static $SIMPLES_WHERE_TYPES = ['int', 'select', 'bool'];

    /** @var boolean : if true the view will have a filter bar */
    protected $filter = true;

    /** @var string Add fields into data query to display list */
    protected $_select = array('*');

    protected $_selectRaw = false;

    /** @var array Fields List to be generated */
    protected $_columns = array();

    /** @var array Add conditions into data query to display list */
    protected $_where = array();

    /** @var array Add with instructions to use jointures configured in model */
    protected $_with = array();

    /* @var boolean */
    protected $_distinct = true;

    /** @var array Add join instructions */
    protected $_join = array();

    /** @var array Add left join instructions */
    protected $_leftJoin = array();

    /** @var boolean */
    protected $_or = false;

    /** @var int Draw data, use by the JQuery Datatable */
    protected $_draw = 1;

    protected $addButton = true;

    protected $moreActions = [];

    protected $bulkActions = false;

    protected abstract function getRequest();

    protected abstract function getRepository();

    protected abstract function getNotificationService();


    /**
     * the variables to inject in the form view (for edit and creation)
     * @return array
     */
    protected function viewVars()
    {
        return ['fields' => $this->_columns, 'filter', $this->_filter];
    }

    /**
     * generate index view and handle ajax request on datatable (use parent::ajaxIndex generic method)
     * @return Response
     */
    public function index()
    {
        if ( ! $this->acl('index'))
        {
            abort(401);
        }

        if ($this->getRequest()->ajax())
        {
            return $this->ajaxIndex();
        } else
        {
            $this->createBreadCrumb();
        }

        return $this->displayView();
    }


    public function toggleActive($id)
    {
        if ( ! $this->acl('edit'))
        {
            abort(401);
        }

        $datas = [];
        $datas['active'] = $this->getRequest()->get('state', false);

        $this->getRepository()->updateRich($datas, $id);
    }

    /**
     * Fill the breadcrumbs created in AbstractAppController
     * with the use of the instance of Breadcrumb defined by the Trait Breadcrumbable
     * @use creitive/laravel5-breadcrumbs vendor
     */
    protected function createBreadCrumb()
    {
        $this->breadcrumbs->addCrumb(trans('app.dashboard'), route('index'));
        $title = $this->title;
        if ( ! isset($title) || ! $title)
        {
            $title = $this->trans('title.management');
        }

        $this->breadcrumbs->addCrumb($title, $this->route('index'));
    }

    /**
     * Read the array $this->_config returned by the configure() implementation
     */
    protected function readConfiguration()
    {
        $this->_columns = $this->getConfigNotEmpty('columns');
        $this->_select = $this->getConfigNotEmpty('select');
        $this->_filter = $this->getConfigNotEmpty('filter');
        $this->_with = $this->getConfig('with');
        $this->_join = $this->getConfig('join');
        $this->_leftJoin = $this->getConfig('left_join');
        $this->_where = $this->getConfig('where');
    }

    /**
     * Prepare columns before the génération of the table
     *  - populateLists
     *  - prepare filterKey for the request
     *
     */
    protected function prepareColumns()
    {
        if (empty($this->_columns))
        {
            return;
        }

        foreach ($this->_columns as $key => $column)
        {
            $this->populateList($column);
            $this->populateEnum($column);
            $this->prepareFilterKey($column);
            $this->_columns[$key] = $column;
        }
    }

    /**
     *
     * Prepare columns for populating lists
     * Fill the list field of the column by calling the listPopuplator method
     * @param array $column
     */
    protected function populateList(&$column)
    {
        if (isset($column['listPopulator']) && method_exists($this, $column['listPopulator']))
        {
            $method = $column['listPopulator'];
            $column['list'] = $this->$method();
        }
    }

    /**
     *
     * Fill the list field of the column by calling the listPopuplator method
     * @param array $column
     */
    protected function populateEnum(&$column)
    {
        if (isset($column['enum']))
        {
            $enum = config($column['enum']);
            if ($enum != null)
            {
                $column['list'] = $enum;
                if (empty($column['callBack']))
                {
                    $column['callBack'] = 'printEnum';
                }
            }
        }
    }

    /**
     * Prepare the filtre_key fields in column
     *  - replace . by ___ for handling PHP native replacment of dot by underscore in HTTP request
     * @param type $column
     */
    protected function prepareFilterKey(&$column)
    {
        if (isset($column['filterKey']))
        {
            $column['filterKey'] = str_replace('.', '___', $column['filterKey']);
        }
    }

    /**
     * add with instruction to the model
     */
    protected function applyWith()
    {
        if ( ! empty($this->_with))
        {
            $this->getRepository()->with($this->_with);
        }
    }

    /**
     * add join instruction to the model
     */
    protected function applyJoin()
    {
        if ( ! empty($this->_join))
        {
            $this->getRepository()->join($this->_join);
        }
        if ( ! empty($this->_leftJoin))
        {
            $this->getRepository()->leftJoin($this->_leftJoin);
        }
    }

    /**
     * Display a ajax listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxIndex($where = false)
    {
        $this->applyJoin();
        $this->applyWhere();
        $recordsTotal = $this->getRepository()->count();
        $this->applyWith();
        $this->getRepository()->applyWhere($this->_where, $this->_or);
        $recordsFilteredTotal = $this->getRepository()->count();

        //dd($this->getRepository()->getSql());

        $data = $this->buildRows();
        $output = array(
            'data'            => $data,
            'draw'            => $this->_draw,
            'recordsFiltered' => $recordsFilteredTotal,
            'recordsTotal'    => $recordsTotal,
        );

        return response()->json($output);
    }

    /**
     * Fills the $this->_where variable with request paramater from the front datatable
     */
    protected function applyWhere()
    {
        if (empty($where = $this->buildAndWhere($this->getRequest(), $this->_columns)))
        {
            $where = $this->buildOrWhere($this->getRequest(), $this->_columns);
            if (count($where))
            {
                $this->_or = true;
            }
        }
        $this->_where = array_merge($this->_where, $where);
    }

    /**
     * Build listing rows
     *
     * @return array
     */
    protected function buildRows()
    {
        $this->initRows();
        $objects = $this->getRepository()->findWhere($this->_where, $this->_select, $this->_selectRaw);
        $data = [];

        //$this->getRepository()->debug();

        foreach ($objects as $key => $object)
        {
            if ($this->bulkActions)
            {
                $data[$key][] = $this->addCheckboxSelection($object);
            }
            foreach ($this->_columns as $name => $field)
            {
                $data[$key]['DT_RowId'] = $object->id;
                if ( ! empty($field['callBack']))
                {
                    $data[$key][] = $this->{$field['callBack']}($field, $object->{$name}, $object->id);
                } else
                {
                    $data[$key][] = $object->{$name};
                }
            }
            $data[$key][] = $this->addRowActions($object);
        }

        return $data;
    }

    /**
     * initialize skip, take and order
     */
    protected function initRows()
    {
        if ($this->_distinct)
        {
            $this->getRepository()->distinct();
        }

        $start = (int) $this->getRequest()->get('start');
        $length = (int) $this->getRequest()->get('length');

        if ($length > 0)
        {
            $this->getRepository()->skip($start);
            $this->getRepository()->take($length);
        }
        $this->_draw = (int) $this->getRequest()->get('draw');
        $order = $this->buildOrder($this->getRequest(), $this->_columns);
        if ($order)
        {
            $this->getRepository()->order($order[0], $order[1]);
        }
    }
    /* ***************************
     * Générics Actions
     * *************************** */

    /**
     * Swith the
     * @param integer $id
     * @return Response
     */
    public function executeSwitchActive($id)
    {
        return $this->executeSwitch('active', $id);
    }

    /**
     * Handle a generic delete request.
     *
     * @return Response
     */
    public function executeDelete($id)
    {
        if ( ! $this->getRequest()->ajax())
        {
            return $this->failureJsonResponse(Response::HTTP_NOT_FOUND);
        }

        if ( ! $this->acl('delete'))
        {
            return $this->failureJsonResponse(Response::HTTP_FORBIDDEN, ['main_message' => trans('app.access_forbidden'), 'messages' => []]);
        }

        $model = $this->getRepository()->reset()->find($id);

        if ($model == null)
        {
            return $this->failureJsonResponse(Response::HTTP_NOT_FOUND);
        }
        // delete news recore
        if($model->getTable() == 'news' or $model->getTable() == 'news_categories')
        {
            if (($checkResponse = $this->checkDeleteNews($model)) != null)
            {
                return $checkResponse;
            }
        } else
        {
            if (($checkResponse = $this->checkDelete($model)) != null)
            {
                return $checkResponse;
            }
        }
        // Delete admin account validation
        if(isset($model->username) && $model->username == 'admin')
        {
            return $this->failureJsonResponse(Response::HTTP_NOT_FOUND);
        }

        $this->getRepository()->delete($id);

        return $this->successJsonResponse(Response::HTTP_NO_CONTENT);
    }

    /**
     * The methods checks that the model can be deleted using $this->$this->getRepository()->checkDelete
     * If not : returns a Response correspond to the error
     * if Yes : returns null
     * @param \App\Models\AbstractModel $model
     * @return null or an Instance of Response
     */
    protected function checkDeleteNews(AbstractNewsModel $model)
    {
        $errors = [];
        if ( ! $this->getRepository()->checkDelete($model, $errors) || $model->parent_id != 0)
        {
            if ( ! empty($errors))
            {
                foreach ($errors as $key => $error)
                {
                    $errors[$key] = $this->trans($error);
                }
            }

            return $this->failureJsonResponse(Response::HTTP_INTERNAL_SERVER_ERROR, ['main_message' => $this->trans('labels.cannot_delete'), 'messages' => $errors]);
        }

        return null;
    }

    /**
     * The methods checks that the model can be deleted using $this->$this->getRepository()->checkDelete
     * If not : returns a Response correspond to the error
     * if Yes : returns null
     * @param \App\Models\AbstractModel $model
     * @return null or an Instance of Response
     */
    protected function checkDelete(AbstractModel $model)
    {
        $errors = [];
        if ( ! $this->getRepository()->checkDelete($model, $errors))
        {
            if ( ! empty($errors))
            {
                foreach ($errors as $key => $error)
                {
                    $errors[$key] = $this->trans($error);
                }
            }

            return $this->failureJsonResponse(Response::HTTP_INTERNAL_SERVER_ERROR, ['main_message' => $this->trans('cannot_delete'), 'messages' => $errors]);
        }

        return null;
    }

    /**
     * Handle a generic switch request.
     * used for switch a boolean field status
     * @param string $column : the column to swith
     * @param integer $id : the column to id
     *
     * @return Response
     */
    protected function executeSwitch($column, $id)
    {
        if ( ! $this->acl('edit'))
        {
            abort(401);
        }

        if ( ! $this->getRequest()->ajax())
        {
            return $this->failureJsonResponse(Response::HTTP_NOT_FOUND);
        }
        $state = $this->getRequest()->get('state', 0);
        $model = $this->getRepository()->reset()->find($id);
        if ($model == null)
        {
            return $this->failureJsonResponse(Response::HTTP_NOT_FOUND);
        }
        $this->getRepository()->update([$column => $state], $id);

        return $this->successJsonResponse(Response::HTTP_NO_CONTENT);
    }

    /**
     * Build list Ordering
     *
     * @param \Illuminate\Http\Request $request
     * @param array $columns
     * @return array|bool
     */
    public function buildOrder($request, $columns)
    {
        $order = $request->get('order');
        if ( ! empty($order) && count($order))
        {
            $o = $order[0];
            $keys = array_keys($columns);

            if ($this->bulkActions && count($this->bulkActions) && $o['column'] > 0)
            {
                $o['column'] = $o['column'] - 1;
            }

            if (array_key_exists($o['column'], $keys))
            {
                return $this->columnsAndOrder($columns, $keys, $o);
            }
        }

        return false;
    }

    /**
     * Get orderBy and orderWay
     *
     * @param array $columns
     * @param array $keys
     * @return array
     */
    protected function columnsAndOrder($columns, $keys, $o)
    {
        $column = $columns[$keys[$o['column']]];
        $orderBy = $keys[$o['column']];
        if (isset($column['orderKey']))
        {
            $column['orderKey'] = $this->getFilterOrder($this->resetFilterKey($column['orderKey']));
            $orderBy = is_array($column['orderKey']) ? $column['orderKey'][0] : $column['orderKey'];
        } else if (isset($column['filterKey']))
        {
            $column['filterKey'] = $this->getFilterOrder($this->resetFilterKey($column['filterKey']));
            $orderBy = is_array($column['filterKey']) ? $column['filterKey'][0] : $column['filterKey'];
        }
        $orderWay = isset($o['dir']) ? $o['dir'] : 'asc';

        return [$orderBy, $orderWay];
    }

    /**
     * Explode string by ',' in order to use first field in order if array
     *
     * @param string $filter_key
     * @return string
     */
    protected function getFilterOrder($filter_key)
    {
        $arr = explode(',', $filter_key);

        return count($arr) > 1 ? $arr[0] : $filter_key;
    }

    /**
     * Explode string by ',' in order to be able to use multiple fields in filterKey
     *
     * @param string $filterKey
     * @return mixed array|string
     */
    protected function getFilterArrOrString($filterKey)
    {
        $arr = explode(',', $filterKey);

        return count($arr) > 0 ? $arr : $filterKey;
    }

    /**
     *  replace ___ by . in the parameter
     * @param string or array of strings $filterKey
     * @return string or array of strings
     */
    protected function resetFilterKey($filterKey)
    {
        return str_replace('___', '.', $filterKey);
    }

    /**
     * Build the given query conditions.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $columns
     * @return array
     */
    public function buildAndWhere(Request $request, array $columns)
    {
        $where = [];
        foreach ($columns as $key => $field)
        {
            $filter = isset($field['filterKey']) ? $field['filterKey'] : $key;

            if ( ! $filter)
            {
                continue;
            }
            $this->pushAndWhere($request, $where, $field['type'], $filter);
        }

        return $where;
    }

    /**
     * for AND restriction
     * Fills the $where array with the restriction defined by filter and value of the filter in the current request
     * @param Request $request
     * @param Array $where
     * @param String $type : field's type
     * @param String $filter
     */
    protected function pushAndWhere(Request $request, &$where, $type, $filter)
    {
        $filterValue = $request->get($filter);
        $filterFrom = $request->get($filter . '_from');
        $filterTo = $request->get($filter . '_to');
        $empty = ['', null];

        if (in_array($filterValue, $empty) && in_array($filterFrom, $empty) && in_array($filterTo, $empty))
        {
            return;
        }
        $filterField = $this->resetFilterKey($this->getFilterArrOrString($filter));
        if (in_array($type, self::$SIMPLES_WHERE_TYPES) && $filterValue != null)
        {
            $where[] = [$filterField, '=', $filterValue];
        } elseif ($type == 'text')
        {
            $where[] = [$filterField, 'LIKE', '%' . trim($filterValue) . '%'];
        } elseif ($type == 'date')
        {
            $this->buildDatesRangeAndWhere($where, $filterField, $filterFrom, $filterTo);
        }
    }

    /**
     * Build the specific filters for search by dates range
     * @param array $where
     * @param String $filterField the name of the request field
     * @param String $filterFrom
     * @param String $filterTo
     */
    protected function buildDatesRangeAndWhere(array &$where, $filterField, $filterFrom, $filterTo)
    {
        if ($filterFrom != null)
        {
            $where[] = [$filterField, '>=', AppTools::formatDate($filterFrom, trans('dates.database_format'), trans('dates.php_date_format'))];
        }
        if ($filterTo != null)
        {
            $where[] = [$filterField, '<', AppTools::formatDate($filterTo, trans('dates.database_format'), trans('dates.php_date_format'))];
        }
    }

    /**
     * Build the given query conditions.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $columns
     * @return array
     */
    protected function buildOrWhere(Request $request, array $columns)
    {
        $where = [];
        $search = $request->get('search');

        foreach ($columns as $key => $field)
        {
            $filter = isset($field['filterKey']) ? $this->resetFilterKey($field['filterKey']) : $key;
            if (empty($search['value']) || ! $filter)
            {
                continue;
            }
            if (is_array($filter))
            {
                foreach ($filter as $f)
                {
                    $this->pushOrWhere($search, $where, $field['type'], $f);
                }
                continue;
            }
            $this->pushOrWhere($search, $where, $field['type'], $filter);
        }

        return $where;
    }

    /**
     * for OR restriction
     * Fills the $where array with the restriction defined by filter and value of the filter in the current request
     * @param String $search
     * @param Array $where
     * @param String $type : field's type
     * @param String $filter
     */
    protected function pushOrWhere($search, &$where, $type, $filter)
    {
        if (in_array($type, self::$SIMPLES_WHERE_TYPES) && is_int($search['value']))
        {
            $where[] = [$filter, '=', (int) $search['value']];
        } elseif ($type == 'text')
        {
            $where[] = [$filter, 'LIKE', '%' . trim($search['value']) . '%'];
        } elseif ($type == 'date')
        {
            $where[] = [$filter, '>=', date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $search['value'])))];
        }
    }
    /*     * *************************************************************************
     *  Callbacks
     * ************************************************************************* */

    /**
     * Generate checkbox for active field
     *
     * @param string $checked
     * @param int $id
     * @return string
     */
    protected function printStatus($field, $checked, $id)
    {
        return view('app.includes.datatable.status')
            ->with('config', $this->_config)
            ->with('field', $field)
            ->with('id', $id)
            ->with('checked', $checked)->render();
    }

    /**
     * Generate checkbox for active field
     *
     * @param string $checked
     * @param int $id
     * @return string
     */
    protected function printStatus2($field, $checked, $id)
    {
        return view('app.includes.datatable.status2')
            ->with('config', $this->_config)
            ->with('field', $field)
            ->with('id', $id)
            ->with('checked', $checked)->render();
    }

    /**
     * Generate checkbox for active field
     *
     * @param string $checked
     * @param int $id
     * @return string
     */
    protected function printStatus3($field, $checked, $id)
    {
        return view('app.includes.datatable.status3')
            ->with('config', $this->_config)
            ->with('field', $field)
            ->with('id', $id)
            ->with('checked', $checked)->render();
    }

    public function printVisible($field, $checked, $id)
    {
        return view('app.includes.datatable.visible')
            ->with('config', $this->_config)
            ->with('field', $field)
            ->with('id', $id)
            ->with('checked', $checked)->render();
    }

    /**
     * Format a bootstrap label using attribute_value item (label and color)
     *
     * @param $field
     * @param $value
     * @param $id
     * @return string
     */
    protected function printStatusAttributable($field, $value, $id)
    {
        return view('app.includes.datatable.status_attributable')
            ->with('value', $value)
            ->render();
    }

    /**
     * Format given date
     *
     * @param Carbon\Carbon $param The current object id
     * @param int $id The current object id
     * @return string
     */
    protected function printDate($field, $param, $id = null)
    {
        $dateFormat = trans('dates.php_datetime_format');

        if (isset($field['dateFormat']))
        {
            $dateFormat = $field['dateFormat'];
        }

        if (is_object($param))
        {
            return $param->format($dateFormat);
        } else
        {
            return $param != "0000-00-00 00:00:00" && $param != null ? date($dateFormat, strtotime($param)) : '';
        }
    }

    /**
     * print the type label in function of the $enumKey parameter
     * use the $field[enums] declared in /config/enums.php
     *
     * @param String $field
     * @param Integer $enumKey the key store in database
     * @param Integer $id
     * @return Response
     */
    protected function printEnum($field, $enumKey, $id)
    {
        $enum = config($field['enum']);
        if (isset($enum[$enumKey]))
        {
            $label = $enum[$enumKey];

            return view('app.includes.datatable.enum')
                ->with('label', trans($label))
                ->with('value', $enumKey)->render();
        }
    }

    /**
     * Generate img
     *
     * @param string $checked
     * @param int $id
     * @return string
     */
    protected function printImage($field, $value, $id)
    {
        $this->getRepository()->reset();
        $model = $this->getRepository()->find($id);
        if ($model && isset($field['relation']))
        {
            return view('app.includes.datatable.image')
                ->with('relation', $field['relation'])
                ->with('model', $model)
                ->render();
        }
    }

    /**
     * Generate link
     *
     * TODO: a revoir, non fonctionnel
     *
     * @param string $checked
     * @param int $id
     * @return string
     */
    protected function printLink($field, $value, $id)
    {
        $this->getRepository()->reset();
        $model = $this->getRepository()->find($id);
        if ($model && isset($field['route']) && isset($field['route_id']))
        {
            $route_id = $field['route_id'];


            if ( ! $model->{$route_id})
            {
                return;
            }

            $route = route($field['route'], $model->{$route_id});

            return view('app.includes.datatable.link')
                ->with('route', $route)
                ->with('value', $value)
                ->render();
        }
    }

    public function printPrice($field, $value, $id)
    {
        return app_number_format($value) . '&nbsp;€';
    }

    protected function printCount($field, $value, $id)
    {
        $this->getRepository()->reset();
        $model = $this->getRepository()->find($id);

        if ($model && isset($field['relation']))
        {
            $relation = $field['relation'];

            if ( ! $model->{$relation})
            {
                return;
            }

            $count = $model->{$relation}->count();

            if ( ! isset($field['relation_route']))
            {
                return $count;
            }


            $route = route($field['relation_route']);

            if (isset($field['relation_route_params']) && count($field['relation_route_params']))
            {
                $route .= '?';

                $i = 0;
                foreach ($field['relation_route_params'] as $key => $f)
                {
                    if ($i > 0)
                        $route .= '&';

                    $route .= $key . '=' . $model->{$f};
                    $i ++;
                }
            }


            return view('app.includes.datatable.link')
                ->with('route', $route)
                ->with('value', $count)
                ->render();
        }
    }

    protected function printListRelation($field, $value, $id)
    {
        $this->getRepository()->reset();
        $model = $this->getRepository()->find($id);

        if ($model && isset($field['relation']) && isset($field['relation_field']))
        {
            $relation = $field['relation'];
            $relation_field = $field['relation_field'];

            $relation_route = null;
            $relation_route_id = null;

            if (isset($field['relation_route']) && isset($field['relation_route_id']))
            {
                $relation_route = $field['relation_route'];
                $relation_route_id = $field['relation_route_id'];
            }

            if ( ! $model->{$relation})
            {
                return;
            }

            return view('app.includes.datatable.list')
                ->with('list', $model->{$relation})
                ->with('relation_field', $relation_field)
                ->with('relation_route', $relation_route)
                ->with('relation_route_id', $relation_route_id)
                ->render();
        }
    }


    protected function printPolymorphicRelation($field, $value, $id)
    {
        $this->getRepository()->reset();
        $model = $this->getRepository()->find($id);

        if ($model && isset($field['relation']) && isset($field['relation_field']))
        {
            $relation = $field['relation'];
            $relation_field = $field['relation_field'];

            if ($model->{$relation})
            {
                if ($model->{$relation} instanceof Collection)
                {

                    return view('app.includes.datatable.list')
                        ->with('list', $model->{$relation})
                        ->with('relation_field', $relation_field)
                        ->render();
                }


                return $model->{$relation}->{$relation_field};
            }
        }
    }


    /**
     * Add the actions to use for each row in the list
     *
     * @param object $object
     * @return string
     */
    protected function addCheckboxSelection($object)
    {
        $actionsTpl = $this->getConfig('rows_checkbox_template');
        if (empty($actionsTpl))
        {
            return '';
        }

        return $this->view($actionsTpl)
            ->with('config', $this->_config)
            ->with('object', $object)
            ->render();
    }


    /**
     * Add the actions to use for each row in the list
     *
     * @param object $object
     * @return string
     */
    protected function addRowActions($object)
    {
        $actionsTpl = $this->getConfig('rows_actions_template');
        if (empty($actionsTpl))
        {
            return '';
        }
// dd($actionsTpl);
        return $this->view($actionsTpl)
            ->with('config', $this->_config)
            ->with('object', $object)->render();
    }

    /**
     * use all configuration variables and datas to display the view
     * use the template defined by config[view] or defaults[view]
     * @param string $title
     * @param object $model
     * @param string $route
     * @param string $method
     * @return Response
     */
    protected function displayView()
    {
        $title = $this->title;
        if ( ! isset($title) || ! $title)
        {
            $title = $this->trans('title.management');
        }
        // we gets the view
        $view = $this->view($this->getConfig('views.index'), compact('title'));

        // we gets the variables to inject into the view
        $vars = $this->viewVars();
        if ( ! empty($vars))
        {
            foreach ($vars as $name => $value)
            {
                $view->with($name, $value);
            }
        }
        $view->with('filter', $this->_filter);
        $view->with('config', $this->_config);
        $view->with('bulkActions', $this->bulkActions);
        $view->with('addButton', $this->addButton);
        $view->with('moreActions', $this->moreActions);


        return $view;
    }

    /**
     * Fields to use in export
     *
     * @return array
     */
    protected function exportFields()
    {
        return $this->getRepository()->makeModel()->getFillable();
    }

    /**
     * Export Header Array
     * TODO à valider ou à améliorer (cf amarante?)
     * TODO si validé à revoir toute les configurations des controller pour inclure les nouvelle configuration
     * TODO si validé à inclure dans intrastore
     *
     * @return array
     */
    protected function exportHeader()
    {
        $fields = $this->exportFields();
        $header = [];
        // dont't needed fields for the export
        $excludeFields = $this->getConfig('export.excludeFields') ? $this->getConfig('export.excludeFields') : ['id'];
        // feilds from join relation
        $joinFields = $this->getConfig('export.joinFields') ? $this->getConfig('export.joinFields') : [];
        foreach ($fields as $field)
        {
            // exclusion of unused fields
            if(in_array($field, $excludeFields)){
                continue;
            }
            $header[] = $this->trans('fields.' . $field);
        }
        //add feilds from join
        foreach ($joinFields as $field)
        {
            $header[] = $this->trans('fields.' . $field);
        }

        return $excludeFields;
    }

    /**
     * Export rows
     * TODO à valider ou à améliorer (cf amarante?)
     * TODO si validé à revoir toute les configurations des controller pour inclure les nouvelle configuration pour l'export
     * TODO si validé à inclure dans intrastore
     *
     * @return array
     */
    protected function exportRows()
    {
        $this->applyJoin();
        $this->applyWhere();
        $recordsTotal = $this->getRepository()->count();
        $this->applyWith();
        $this->getRepository()->applyWhere($this->_where, $this->_or);
        $this->initRows();
        $objects = $this->getRepository()->findWhere($this->_where, $this->_select);
        //$fields = $this->exportFields();

        // dont't needed fields for the export
        $excludeFields = $this->getConfig('export.excludeFields') ? $this->getConfig('export.excludeFields') : ['id'];

        $rows = [];
        foreach ($objects as $object)
        {
            $rows[$object->id] = [];
            foreach ($object->getAttributes() as $key => $val) {
                // exclusion of unused fields
                if (in_array($key, $excludeFields)) {
                    continue;
                }
                if ($key == 'civility') {
                    $rows[$object->id][] = $val == 1 ? 'Monsieur' : 'Madame';
                } else if($key == 'ambassador' || $key == 'club_lilial') {
                    $rows[$object->id][] = $val == 1 ? 'Yes' : 'No';
                } else if ($key == 'active' || $key == 'newsletter') {
                    $rows[$object->id][] = $val == 1 ? 'Actif' : 'Inactif';
                } else {
                    $rows[$object->id][] = $val;
                }
            }
//            foreach ($fields as $field)
//            {
//                if ($field == 'civility') {
//                    $rows[$object->id][] = $object->{$field} == 1 ? 'Monsieur' : 'Madame';
//                } else if ($field == 'active') {
//                    $rows[$object->id][] = $object->{$field} == 1 ? 'Actif' : 'Inactif';
//                } else {
//                    $rows[$object->id][] = $object->{$field};
//                }
//            }
        }

        return $rows;
    }



    /**
     * BULK ACTIONS
     */

    /**
     * Export items to Excel
     *
     * @return Response Get excel file
     */
    public function exportExcel()
    {
        Excel::create('export',
            function ($excel) {
                $excel->sheet('Sheet 1',
                    function ($sheet) {
                        $sheet->loadView('app.contents.admin.export.excel',
                            [
                                'header' => method_exists($this, 'excelHeader') ? $this->excelHeader() : $this->exportHeader(),
                                'rows'   => method_exists($this, 'excelRows') ? $this->excelRows() : $this->exportRows(),
                            ]);
                    });
            })->download('xls');
    }

    /**
     *
     */
    public function bulkActive()
    {
        if ( ! $this->acl('edit'))
        {
            abort(401);
        }

        foreach ($this->getRequest()->get('ids') as $id)
        {
            $this->getRepository()->updateRich(['active' => true], $id);
        }
    }

    /**
     *
     */
    public function bulkUnactive()
    {
        if ( ! $this->acl('edit'))
        {
            abort(401);
        }

        foreach ($this->getRequest()->get('ids') as $id)
        {
            $this->getRepository()->updateRich(['active' => false], $id);
        }
    }

    /**
     *
     */
    public function bulkDelete()
    {
        if ( ! $this->acl('delete'))
        {
            abort(401);
        }

        foreach ($this->getRequest()->get('ids') as $id)
        {
            $this->executeDelete($id);
        }
    }

    /**
     * Import items to Excel
     *
     * @return Response Get excel file
     */
    public function importExcel(Request $request)
    {
        if($request->hasFile('excel_file'))
        {
            $path = $request->file('excel_file')->getRealPath();
            $data = Excel::load($path)->get()->toArray();

            // Conver key excel file
            $dataKeyConvert[] = [];
            foreach ($data as $keyTotal => $items) {
                foreach ($items as $key => $value) {
                    $dataKeyConvert[$keyTotal][$this->convertKeyExcelFile($key)] = $data[$keyTotal][$key];
                    unset($data[$keyTotal][$key]);
                }
            }

            // Conver value excel file
            $dataValueConvert[]= [];
            foreach ($dataKeyConvert as $keyTotal => $items) {
                foreach ($items as $key => $value) {
                    $dataValueConvert[$keyTotal][$key] = $this->convertValueExcelFile($key, $value);
                }
            }

            $data = $this->beforeImport($dataValueConvert);

            if($data['data'] == null && $data['status'] == 0)
            {
                $this->getNotificationService()->flashNotify($this->trans('labels.import_user_null'), 'danger');
            }
            else if($data['data'] == null && $data['status'] == 1)
            {
                $this->getNotificationService()->flashNotify($this->trans('labels.import_user_updated'), 'success');
            }
            else if($data['data'] == null && $data['status'] == 2)
            {
                $this->getNotificationService()->flashNotify('"'.$data['username'].'" existe déjà. S\'il vous plaît vérifier!', 'danger');
            }
            else if($data['data'] == null && $data['status'] == 3)
            {
                $this->getNotificationService()->flashNotify('"'.$data['email'].'" existe déjà. S\'il vous plaît vérifier!', 'danger');
            }
            else
            {
                // Store data to (users and clients table)
                $this->storeDataUser($data['data']['user']);
                $this->storeDataClient($data['data']['user'], $data['data']['client']);

                $this->getNotificationService()->flashNotify($this->trans('labels.imported'), 'success');
            }

        } else
        {
            $this->getNotificationService()->flashNotify($this->trans('labels.import_failed'), 'danger');
        }

        return back();
    }

    public function checkConditionData($array)
    {
        $user = new User;
        $users = $user::withTrashed()->get()->toArray();
        $arrayNew = array('data' => $array, 'condition' == false);
        foreach ($users as $key => $user) {
            if($users[$key]['deleted_at'] != null && ($users[$key]['username'] == $array['username'] || $users[$key]['email'] == $array['email']))
            {
                $arrayNew = array('data' => $array, 'condition' => true, 'deleted_at' => true);
                continue;
            }
            else if($users[$key]['username'] == $array['username'])
            {
                $arrayNew = array('data' => $array, 'condition' => true, 'username' => $array['username']);
                break;
            }
            else if($users[$key]['email'] == $array['email'])
            {
                $arrayNew = array('data' => $array, 'condition' => true, 'email' => $array['email']);
                break;
            }
        }
        return $arrayNew;
    }

    public function updateIfConditionData($data)
    {
        $dataSlice = $this->sliceData($data['data']);

        $dataSlice['user']['deleted_at'] = null;

        $query = User::withTrashed()
                      ->where('username', $dataSlice['user']['username'])
                      ->orWhere('email', $dataSlice['user']['email']);

        $user = $query->update($dataSlice['user']);

        $user_id = $query->first()->id;
        $client = Client::where('user_id', $user_id)->first();

        $dataSlice['client']['user_id'] = $user_id;

        if($client != null){
            Client::where('user_id', $user_id)
                    ->update($dataSlice['client']);
        }
        else
        {
            $clients = new Client;

            $clients->user_id = $user_id;
            $clients->type = $dataSlice['client']['type'];
            $clients->club_lilial = $dataSlice['client']['club_lilial'];
            $clients->ambassador = $dataSlice['client']['ambassador'];

            $clients->save();
        }

    }

    public function sliceData($data)
    {
        $user = new User;
        $userArray = $user->getFillable();
        $userData = [];
        
        $client = new Client;
        $clientArray = $client->getFillable();
        $clientData = [];

        foreach ($data as $key => $value) {
            if(in_array($key, $userArray)) {
                $userData[$key] = $value;
            }
            if(in_array($key, $clientArray)) {
                $clientData[$key] = $value;
                $clientData['user_id'] = null;
            }
        }
        unset($userData['created_at']);

        return array('user' => $userData, 'client' => $clientData);
    }

    public function beforeImport($data)
    {
        foreach ($data as $keyData => $array) {
            if(empty($array['civility']) || empty($array['firstname']) || empty($array['lastname']) || empty($array['email']) || empty($array['username']))
            {
                $resultData = ['data' => null, 'status' => 0];
                continue;
            }
            $result = $this->checkConditionData($array);
            if($result['condition'] == true)
            {
                if(isset($result['deleted_at']))
                {
                    $this->updateIfConditionData($result);
                    $resultData = ['data' => null, 'status' => 1];
                    continue;
                }
                else if(isset($result['username']))
                {
                    $resultData = ['data' => null, 'status' => 2, 'username' => $result['username']];
                    break;
                }
                else if(isset($result['email']))
                {
                    $resultData = ['data' => null, 'status' => 3, 'email' => $result['email']];
                    break;
                }
            }
            else
            {
                $dataSlice[$keyData] = $this->sliceData($result['data']);
                foreach ($dataSlice as $key => $array) {
                    $userData[$key] = $array['user'];
                    $clientData[$key] = $array['client'];
                }
                $resultData = ['data' => array('user' => $userData, 'client' => $clientData), 'status' => 4];
            }
        }
        return $resultData;
    }

    /**
     * [getDataUserAfterStore function]
     * @param  array $dataUser [count recore]
     * @return array $users_id
     */
    public function getDataUserAfterStore($dataUser)
    {
        $user = new User;
        $users_id = $user::orderBy('id', 'desc')
                          ->pluck('id')
                          ->take(count($dataUser))
                          ->toArray();
        sort($users_id);

        return $users_id;
    }

    /**
     * [storeDataUser function]
     * @param  [array] $dataUser
     */
    public function storeDataUser($dataUser)
    {
        $user = new User;
        foreach ($dataUser as $data) {
            $user->create($data);
        }
    }

    /**
     * [storeDataClient function]
     * @param  [array] $dataUser
     * @param  [array] $dataClient
     */
    public function storeDataClient($dataUser, $dataClient)
    {
        foreach ($dataClient as $key => $items) {
            $dataClient[$key]['user_id'] = $this->getDataUserAfterStore($dataUser)[$key];
        }

        $client = new Client;
        foreach ($dataClient as $data) {
            $client->create($data);
        }
    }

    /**
     * [convertValueExcelFile function]
     * @param  [more type] $value
     * @return [more type] $value
     */
    public function convertValueExcelFile($key, $value)
    {
        if($value == 'Actif' || $value == 'Yes')
            return 1;
        else if($value == 'Inactif' || $value == 'No')
            return 0;
        else if($value == 'Madame')
            return 2;
        else if($value == 'Monsieur')
            return 1;
        else if(is_float($value))
            return (int) $value;
        else if($value == 'Client')
            return 4;
        else if($key == 'role_id' && $value != 'Client')
            return 3;
        else if($key == 'active' || $key == 'newsletter' || $key == 'club_lilial' || $key == 'ambassador' && $value == null)
            return 0;
        else if($key == 'type' && $value == null)
            return 'user';
        else
            return $value;
    }

    /**
     * [convertKeyExcelFile function]
     * @param  [string] $key
     * @return [string] $key
     */
    public function convertKeyExcelFile($key)
    {
        switch ($key) {
          case 'utilisateur_id':
            return $key = 'user_id';
            break;
          case 'client_id':
            return $key = 'client_id';
            break;
          case 'prenom':
            return $key = 'firstname';
            break;
          case 'nom_de_famille':
            return $key = 'lastname';
            break;
          case 'civilite':
            return $key = 'civility';
            break;
          case 'nom_dutilisateur':
            return $key = 'username';
            break;
          case 'email':
            return $key = 'email';
            break;
          // case 'mot_de_passe':
          //   return $key = 'password';
          //   break;
          case 'telephone':
            return $key = 'phone';
            break;
          case 'mobile':
            return $key = 'mobile';
            break;
          // case 'createur':
          //   return $key = 'creator_id';
          //   break;
          case 'newsletter':
            return $key = 'newsletter';
            break;
          case 'role':
            return $key = 'role_id';
            break;
          case 'type':
            return $key = 'type';
            break;
          case 'club':
            return $key = 'club_lilial';
            break;
          case 'ambassadeur':
            return $key = 'ambassador';
            break;
          case 'statut':
            return $key = 'active';
            break;
          case 'cree_a':
            return $key = 'created_at';
            break;
          
          default:
            # code...
            break;
        }
    }
}