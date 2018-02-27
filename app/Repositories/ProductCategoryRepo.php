<?php

namespace App\Repositories;

class ProductCategoryRepo extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\SkyProductCategory';
    }
}
