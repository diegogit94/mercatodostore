<?php

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::view('/', 'welcome')->name('welcome');
Route::resource('/', 'WelcomeController');

//Store Routes
Route::get('/store', 'StoreController@index')->name('store.index');
Route::get('/search', 'StoreController@search')->name('store.search');
Route::get('/store/{product}', 'StoreController@show')->name('store.show');

//Cart Routes
Route::get('/cart', 'CartController@index')->name('cart.index');
Route::post('/cart', 'CartController@store')->name('cart.store')->middleware('auth');
Route::delete('/cart/{product}', 'CartController@remove')->name('cart.remove');
Route::patch('/cart/{product}', 'CartController@update')->name('update.cart');

//Checkout Routes
Route::get('/checkout', 'CheckoutController@index')->name('checkout.index')->middleware('auth');
Route::post('/checkout', 'CheckoutController@placeToPayCheckout')->name('checkout.placeToPayCheckout');
Route::get('/success/{reference}', 'ThankYouController@index')->name('thankyou.index');

//History Routes
Route::get('/history', 'HistoryController@index')->name('history.index')->middleware('auth');
Route::get('/history/{order}', 'HistoryController@retryPayment')->name('history.retryPayment');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

//Admin/Users routes
Route::get('/admin', 'UserController@index')->name('users.index')->middleware('admin');
Route::view('/admin/createUser', 'admin.createUser')->name('users.create');
Route::post('/admin/createUser', 'UserController@store')->name('users.store');
Route::delete('/admin/{user}', 'UserController@destroy')->name('users.destroy');
Route::get('/admin/{user}/admin.editUsers', 'UserController@edit')->name('users.edit');
Route::patch('/admin/{user}/admin.editUsers', 'UserController@update')->name('users.update');
Route::patch('/admin/{user}', 'UserController@activate')->name('users.activate');

Route::get('/products/productsExport', 'ProductController@export')->name('products.export');
Route::post('/products/productsImport', 'ProductController@import')->name('products.import');

//product routes
Route::get('/products' , 'ProductController@index')->name('products.index')->middleware('admin');
Route::view('/products/createProduct', 'admin.createProduct')->name('products.create');
Route::post('/products/createProduct', 'ProductController@store')->name('products.store');
Route::get('/products/{product}/admin.editProduct', 'ProductController@edit')->name('products.edit');
Route::delete('/products/{product}', 'ProductController@destroy')->name('products.destroy');
Route::patch('/products/{product}/admin.editProduct', 'ProductController@update')->name('products.update');
Route::patch('/products/{product}', 'ProductController@visible')->name('products.visible');
