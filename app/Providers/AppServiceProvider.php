<?php

namespace App\Providers;

use App\Repositories\EloquentProductCategory;
use App\Repositories\ProductCategoryRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ProductCategoryRepository::class, EloquentProductCategory::class);
    }
}
