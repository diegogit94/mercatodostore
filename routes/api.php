<?php

use CloudCreativity\LaravelJsonApi\Facades\JsonApi;

JsonApi::register('v1')->routes( function($api) {
    $api->resource('products')->only('create', 'update')->middleware('auth');
    $api->resource('products')->except('create', 'update');
});
