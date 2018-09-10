<?php

namespace App\Repositories\Eloquent;

use App\Models\EDM\Upload;
use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class Repository
 */
abstract class Repository implements RepositoryInterface
{

    /**
     * @var App
     */
    private $app;

    /**
     * @var
     */
    protected $model;

    /**
     * @var
     */
    protected $newModel;

    /**
     * Load with softely deleted elements
     * @var bool
     */
    public $withTrashed = false;

    /**
     * @param App $app
     * @throws \Repositories\Exceptions\RepositoryException
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract public function model();

    /**
     * @param array $columns
     * @param string $orderField
     * @param string $orderDirection
     * @return Collection
     */
    public function all($columns = array('*'), $orderField = null, $orderDirection = "asc")
    {
        if ( ! empty($orderField) && ! empty($orderDirection))
        {
            return $this->model->orderBy($orderField, $orderDirection)->get($columns);
        }

        return $this->model->get($columns);
    }

    /**
     * @param array $relations
     * @return $this
     */
    public function with(array $relations)
    {
        $this->model = $this->model->with($relations);

        return $this;
    }

    /**
     * @param array $joins
     * @return $this
     */
    public function join(array $joins)
    {
        foreach ($joins as $join)
        {
            if (is_array($join) && count($join) === 4)
            {
                $this->model = $this->model->join($join[0], $join[1], $join[2], $join[3]);
            }
        }

        return $this;
    }

    /**
     * @param array $joins
     * @return $this
     */
    public function leftJoin(array $joins)
    {
        foreach ($joins as $join)
        {
            if (is_array($join))
            {
                if (count($join) === 2 && $join[1] instanceof \Closure)
                {
                    $this->model = $this->model->leftJoin($join[0], $join[1]);
                } elseif (count($join) === 4)
                {
                    $this->model = $this->model->leftJoin($join[0], $join[1], $join[2], $join[3]);
                }
            }
        }

        return $this;
    }

    /**
     * @param int $offSet
     * @return $this
     */
    public function skip($offSet)
    {
        $this->model = $this->model->skip($offSet);

        return $this;
    }

    /**
     * @param int $perPage
     * @return $this
     */
    public function take($perPage = 20)
    {
        $this->model = $this->model->take($perPage);

        return $this;
    }

    /**
     * @param  string $orderBy
     * @param  string $orderWay
     * @return $this
     */
    public function order($orderBy, $orderWay = 'asc')
    {
        $this->model = $this->model->orderBy($orderBy, $orderWay);

        return $this;
    }

    /**
     * @param  string $value
     * @param  string $key
     * @return array
     */
    public function pluck($value, $key = null)
    {
        $lists = $this->model->pluck($value, $key);
        if (is_array($lists))
        {
            return $lists;
        }

        return $lists->all();
    }

    /**
     * @return bool
     */
    public function exists()
    {
        return $this->model->exists;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $this->reset();
        $this->model->fill($data);
        $this->model->save();

        return $this->model;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function save(array $data)
    {
        return $this->model->fill($data)->save();
    }

    /**
     * save a model without massive assignment
     *
     * @param array $data
     * @return bool
     */
    public function saveModel(array $data = [])
    {
        foreach ($data as $k => $v)
        {
            $this->model->$k = $v;
        }

        return $this->model->save();
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute = "id")
    {
        return $this->model->where($attribute, '=', $id)->update($data);
    }

    /**
     * @param  array $data
     * @param  $id
     * @return mixed
     */
    public function updateRich(array $data, $id)
    {
        if ( ! ($model = $this->model->find($id)))
        {
            return false;
        }

        return $model->fill($data)->save();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        if ($model = $this->find($id))
        {
            return $model->delete();
        }

        return null;
    }

    /**
     * Check if the model can be deleted or not
     * @param $model
     * @param array $errors
     * @return boolean true if the deletion is possible else false (and the $errors whill be filled with the errors)
     */
    function checkDelete($model, array &$errors)
    {
        return true;
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'))
    {
        if ($this->withTrashed)
        {
            return $this->model->withTrashed()->find($id, $columns);
        } else
        {
            return $this->model->find($id, $columns);
        }
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findAllBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where($attribute, '=', $value)->get($columns);
    }

    /**
     * Find a collection of models by the given query conditions.
     *
     * @param array $where
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function findWhere($where, $columns = ['*'], $select_raw = false)
    {
        $this->applyWhere($where);

        if ($this->withTrashed)
        {
            return $this->model->withTrashed();
        }

        if ($select_raw)
        {
            return $this->model->select(DB::raw(implode(', ', $columns)))->get();
        } else
        {
//            echo $this->model->toSql() . "\n";
            return $this->model->get($columns);
        }
    }

    /**
     * Count a collection of models
     *
     * @return int
     */
    public function count()
    {
        return $this->model->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws RepositoryException
     */
    public function makeModel()
    {
        return $this->setModel($this->model());
    }

    /**
     * Reinitialize query builder in this instance
     * @return $this
     */
    public function reset()
    {
        return $this->makeModel();
    }

    /**
     * Set Eloquent Model to instantiate
     *
     * @param $eloquentModel
     * @return Model
     * @throws RepositoryException
     */
    public function setModel($eloquentModel)
    {
        $this->newModel = $this->app->make($eloquentModel);

        if ( ! $this->newModel instanceof Model)
        {
            throw new RepositoryException("Class {$this->newModel} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $this->newModel;
    }

    /**
     * get Eloquent New Model
     *
     * @param $eloquentModel
     * @return Model
     * @throws RepositoryException
     */
    public function newModel($eloquentModel)
    {
        $this->newModel = $this->app->make($eloquentModel);

        if ( ! $this->newModel instanceof Model)
        {
            throw new RepositoryException("Class {$this->newModel} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->newModel;
    }

    /**
     * Get Eloquent Model
     *
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param array $where
     * @param bool $or
     * @return int
     */
    public function applyWhere(array $where, $or = false)
    {
        foreach ($where as $field => $value)
        {
            if ($value instanceof \Closure)
            {
                $this->model = ( ! $or) ? $this->model->where($value) : $this->model->orWhere($value);
            } elseif (is_array($value))
            {
                if (count($value) === 3)
                {
                    list($field, $operator, $search) = $value;
                    if (is_array($field))
                    {
                        $this->model->where(function ($query) use ($field, $operator, $search) {
                            foreach ($field as $key => $value)
                            {
                                $query->orWhere($value, $operator, $search);
                            }
                        });
                    } else
                    {
                        //   dd($field . ' ' . $operator . ' ' . $search);
                        $this->applyWhereWithOperator($field, $operator, $search, $or);
                    }
                } elseif (count($value) === 2)
                {
                    list($field, $search) = $value;
                    $this->model = ( ! $or) ? $this->model->where($field, '=', $search) : $this->model->orWhere($field,
                        '=', $search);
                }
            } else
            {
                $this->model = ( ! $or) ? $this->model->where($field, '=', $value) : $this->model->orWhere($field, '=',
                    $value);
            }
        }

        return $this;
    }

    /**
     *
     * @param String $field
     * @return Repository
     */
    public function applyWhereNull($field)
    {
        $this->model = $this->model->whereNull($field);

        return $this;
    }

    /**
     * apply where with an operator (value == array[3])
     * @param string $field
     * @param array $value
     */
    private function applyWhereWithOperator($field, $operator, $search, $or = false)
    {
        if ($operator == 'IN')
        {
            $this->model = ( ! $or) ? $this->model->whereIn($field, $search) : $this->model->orWhereIn($field, $search);
        } else
        {
            $this->model = ( ! $or) ? $this->model->where($field, $operator, $search) : $this->model->orWhere($field,
                $operator, $search);
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return $this->model->validator($data);
    }

    public function mediaPath()
    {
        return $this->model->mediaPath();
    }

    public function storagePath()
    {
        return $this->model->storagePath();
    }

    /**
     * Set my model in repository (useful to set model and get it by repository using getModel)
     * @param Model $model
     */
    public function setMyModel($model)
    {
        $this->model = $model;
    }

    /**
     * Fill attributes
     *
     * @param array $data
     */
    public function fill(array $data)
    {
        $this->model->fill($data);
    }

    /**
     * @param string $name : search key for restriction by name (like ...%)
     * @param integer $offset
     * @param integer $limit
     * @return Illuminate\Support\Collection of entities
     */
    public function findByName($name = null, $offset = 0, $limit = 0)
    {
        $this->reset();
        $model = $this->model;
        if ($name != null)
        {
            $model = $model->where('name', 'like', $name . '%');
        }
        if ($offset != 0)
        {
            $model = $model->offset($offset);
        }
        if ($limit != 0)
        {
            $model = $model->limit($limit);
        }

        return $model->get();
    }

    public function findOrFail($id, $columns = array('*'))
    {
        return $this->model->findOrFail($id, $columns);
    }

    public function firstOrNew(array $attributes)
    {
        return $this->model->firstOrNew($attributes);
    }

    public function firstOrCreate(array $attributes)
    {
        return $this->model->firstOrCreate($attributes);
    }

    /**
     * @param $field
     * @param Upload $upload
     * @return bool|Model
     */
    public function attachUpload($field, Upload $upload)
    {
        if ( ! $this->checkRelationExists($field))
        {
            return false;
        }

        $model = $this->getModel();
        $model->{$field}()->attach($upload);
        $model->save();

        return $model;
    }

    /**
     * @param $field
     * @param Upload $upload
     * @return bool|Model
     */
    public function detachUpload($field, Upload $upload)
    {
        if ( ! $this->checkRelationExists($field))
        {
            return false;
        }

        $model = $this->getModel();
        $model->{$field}()->detach($upload);
        $model->save();

        return $model;
    }

    /**
     * @param $field
     * @param Upload $upload
     * @return bool|Model
     */
    public function associateUpload($field, Upload $upload)
    {
        if ( ! $this->checkRelationExists($field))
        {
            return false;
        }

        $model = $this->getModel();
        $model->{$field}()->associate($upload);
        $model->save();

        return $model;
    }

    /**
     * @param $field
     * @param Upload $upload
     * @return bool|Model
     */
    public function dissociateUpload($field, Upload $upload)
    {
        if ( ! $this->checkRelationExists($field))
        {
            return false;
        }

        $model = $this->getModel();
        $model->{$field}()->dissociate($upload);
        $model->save();

        return $model;
    }


    /**
     * @param $field
     * @return bool
     */
    public function checkRelationExists($field)
    {
        if (count($this->getModel()->{$field}))
        {
            return true;
        }

        return false;
    }

    public function distinct()
    {
        return $this->model->distinct();
    }

    public function debug()
    {
        DB::enableQueryLog();
        $this->model->get();
        dd(DB::getQueryLog());
    }

}
