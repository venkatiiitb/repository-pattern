<?php

namespace App\Repositories;

use App\SkyProductCategory;

class EloquentProductCategory implements ProductCategoryRepository
{
    /**
     * @var $model
     */
    private $model;

    /**
     * EloquentProductCategory constructor.
     *
     * @param App\SkyProductCategory $model
     */
    public function __construct(SkyProductCategory $model)
    {
        $this->model = $model;
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
