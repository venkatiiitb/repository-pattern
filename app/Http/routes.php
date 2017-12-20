<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

// json to swagger json
Route::post('convert-to-swagger-json', 'JsonController@convertToSwaggerJSON');

// Product Category Routes
Route::group(['prefix' => 'product-categories'], function () {
    Route::get('/{id?}', [
        'uses' => 'ProductCategoryController@getAllProductCategories',
        'as' => 'product-category.index'
    ]);

    Route::post('store', [
        'uses' => 'ProductCategoryController@postStoreProductCategory',
        'as' => 'product-category.store'
    ]);

    Route::patch('{id}/update', [
        'uses' => 'ProductCategoryController@postUpdateProductCategory',
        'as' => 'product-category.update'
    ]);

    Route::delete('{id}/delete', [
        'uses' => 'ProductCategoryController@postDeleteProductCategory',
        'as' => 'product-category.delete'
    ]);
});