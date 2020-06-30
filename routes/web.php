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

Route::view('/', 'welcome');

Route::view('/store', 'store');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

//Admin CRUD
Route::get('/admin', 'UserController@index')->name('users.show')->middleware('admin');
Route::post('/admin', 'UserController@store')->name('users.store');
Route::delete('/admin/{user}', 'UserController@destroy')->name('users.destroy');
Route::get('/admin/{user}/editUsers', 'UserController@edit')->name('users.edit');
Route::patch('/admin/{user}/editUsers', 'UserController@update')->name('users.update');
Route::patch('/admin/{user}', 'UserController@activate')->name('users.activate');

//Admin create user
Route::view('/admin/createUser', 'createUser')->name('create.user');
Route::post('/admin/createUser', 'UserController@adminCreateUser')->name('admin.create.user');