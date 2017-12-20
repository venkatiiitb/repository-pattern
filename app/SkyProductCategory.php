<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SkyProductCategory extends Model
{
    protected $table = 'sky_product_category' ;
    public $timestamps = false ;
    protected $fillable = ['name'] ;
}
