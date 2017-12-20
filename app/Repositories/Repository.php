<?php

namespace App\Repositories;

use Illuminate\Container\Container as App;
use Bosnadev\Repositories\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\Model;

abstract class Repository implements ProductCategoryRepository
{
    /**
     * @var $model
     */
    private $model;

    /**
     * @var $app
     */
    private $app;

    /**
     * EloquentProductCategory constructor.
     *
     * @param App $app
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
    abstract function model();

    /**
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel() {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model)
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->model = $model;
    }

    /**
     * Get all product categories.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * Create a new Product Category.
     *
     * @param array $attributes
     *
     * @return App\SkyProductCategory
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * Update a Product Category.
     *
     * @param integer $id
     * @param array $attributes
     *
     * @return App\SkyProductCategory
     */
    public function update($id, array $attributes)
    {
        return $this->model->find($id)->update($attributes);
    }

    /**
     * Delete a Product Category.
     *
     * @param integer $id
     *
     * @return boolean
     */
    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }

    /**
     * Get Product Category by id.
     *
     * @param integer $id
     * @param array $columns
     *
     * @return App\SkyProductCategory
     */
    public function find($id, $columns = array('*'))
    {
        return $this->model->find($id, $columns);
    }

    /**
     * Get Product Category by id.
     *
     * @param string $attribute
     * @param string $value
     * @param array $columns
     *
     * @return App\SkyProductCategory
     */
    public function findBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where($attribute, $value)->first($columns);
    }

    /**
     * Get Product Category by id.
     *
     * @param array $conditions
     * @param array $columns
     *
     * @return App\SkyProductCategory
     */
    public function getBy($conditions, $columns = array('*'))
    {
        return $this->model->where($conditions)->first($columns);
    }

    /**
     * Get Product Category by id.
     *
     * @param array $conditions
     * @param array $columns
     *
     * @return App\SkyProductCategory
     */
    public function updateBy($conditions, $columns = array('*'))
    {
        return $this->model->where($conditions)->update($columns);
    }
}
