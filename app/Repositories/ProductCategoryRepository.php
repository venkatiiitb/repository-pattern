<?php

namespace App\Repositories;

interface ProductCategoryRepository
{
    public function getAll();

    public function create(array $attributes);

    public function update($id, array $attributes);

    public function delete($id);

    public function find($id, $columns = array('*'));

    public function findBy($field, $value, $columns = array('*'));

    public function getBy($conditions, $columns = array('*'));

    public function updateBy($conditions, $columns = array('*'));
}

