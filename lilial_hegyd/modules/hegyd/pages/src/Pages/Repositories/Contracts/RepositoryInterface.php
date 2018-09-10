<?php namespace Hegyd\Pages\Repositories\Contracts;


/**
 * Interface RepositoryInterface
 * @package Hegyd\Pages\Repositories\Contracts
 */
interface RepositoryInterface
{

    /**
     * @param array $columns
     * @param string $orderField
     * @param string $orderDirection
     * @return mixed
     */
    public function all($columns = array('*'), $orderField = null, $orderDirection = "");

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param array $data
     * @return bool
     */
    public function saveModel(array $data);

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Check if the model can be deleted or not
     * @param $model
     * @param array $errors
     * @return boolean true if the deletion is possible else false (and the $errors whill be filled with the errors)
     */
    function checkDelete($model, array &$errors);

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'));

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = array('*'));

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findAllBy($field, $value, $columns = array('*'));

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findOrFail($id, $columns = array('*'));

    /**
     * @param $attributes
     * @return mixed
     */
    public function firstOrNew(array $attributes);

    /**
     * @param $attributes
     * @return mixed
     */
    public function firstOrCreate(array $attributes);


    /**
     * @param array $where
     * @param array $columns
     * @return mixed
     */
    public function findWhere($where, $columns = array('*'));

    /**
     * @return int
     */
    public function count();

    /**
     * @return mixed
     */
    public function distinct();

    /**
     * add this restriction to the model
     * @param array $where
     * @param boolean $or
     */
    public function applyWhere(array $where, $or = false);

    /**
     * @param array $joins
     * @return $this
     */
    public function join(array $joins);

    /**
     * @param array $joins
     * @return $this
     */
    public function leftJoin(array $joins);

    /**
     * Reinitialize query builder in this instance
     * @return $this
     */
    public function reset();

    /**
     * @param array $relations
     * @return $this
     */
    public function with(array $relations);

    /**
     * @param string $name : search key for restriction by name (like ...%)
     * @param integer $offset
     * @param integer $limit
     * @return Illuminate\Support\Collection of entities
     */
    public function findByName($name = null, $offset = 0, $limit = 0);

    public function pluck($value, $key = null);
}
