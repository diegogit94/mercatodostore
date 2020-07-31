<?php

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

//Route::view('/store', 'store.store')->name('store');
Route::get('/store', 'StoreController@index')->name('store.index');
Route::get('/search', 'StoreController@search')->name('store.search');
Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

//Admin CRUD
Route::get('/admin', 'UserController@index')->name('users.index')->middleware('admin');
Route::view('/admin/createUser', 'admin.createUser')->name('users.create');
Route::post('/admin/createUser', 'UserController@store')->name('users.store');
Route::delete('/admin/{user}', 'UserController@destroy')->name('users.destroy');
Route::get('/admin/{user}/admin.editUsers', 'UserController@edit')->name('users.edit');
Route::patch('/admin/{user}/admin.editUsers', 'UserController@update')->name('users.update');
Route::patch('/admin/{user}', 'UserController@activate')->name('users.activate');
