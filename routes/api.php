<?php

use CloudCreativity\LaravelJsonApi\Facades\JsonApi;

JsonApi::register('v1')->routes( function($api) {
    $api->resource('products')->only('create', 'update', 'delete')->middleware('admin');
    $api->resource('products')->except('create', 'update', 'delete');
    $api->resource('users')->middleware('admin');
});
