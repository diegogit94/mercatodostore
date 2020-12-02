<?php

namespace App\Providers;

use App\Providers\JsonApi\JsonApiBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use App\Product;
use App\Observers\ProductObserver;
use App\Category;
use App\Observers\CategoryObserver;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Product::observe(ProductObserver::class);
        Category::observe((CategoryObserver::class));

        Builder::mixin(new JsonApiBuilder);
    }
}
