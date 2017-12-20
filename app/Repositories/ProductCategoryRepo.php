<?php

namespace App\Repositories;

use App\SkyProductCategory;

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

    public function getSelectedItem()
    {
        return SkyProductCategory::find(1);
    }
}
