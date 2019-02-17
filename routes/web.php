<?php

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


Route::get('/', 'HomeController@index');



Route::get('/cars', 'CarsController@index')->name('cars');



Route::get('/car_marks/{carId}', 'CarModelsController@getCarMarks');

Route::post('/cars', 'CarModelsController@store');

Route::delete('/cars/{car_model}', 'CarModelsController@destroy');



Route::get('/products', 'ProductsController@index')->name('products');

Route::post('/products', 'ProductsController@store');

Route::get('/products/{product}', 'ProductsController@show')->name('show.product');

Route::get('/products/edit/{product}', 'ProductsController@edit')->name('edit.product');

Route::patch('/products/update/{id}', 'ProductsController@update');

Route::delete('/products/{product}', 'ProductsController@destroy');



Route::post('/products/{product}/applyings', 'ApplyingsController@storeWithAjax');

Route::delete('/applyings/{applying}', 'ApplyingsController@destroy');

Route::post('/applyings/{id}', 'ApplyingsController@destroyWithAjax');




Route::post('/products/{product}/modifications', 'ModificationsController@storeWithAjax');

Route::post('/products/modifications/photo', 'ModificationsController@storePhotoWithAjax');

Route::post('/modifications/{id}', 'ModificationsController@destroyWithAjax');

Route::delete('/modifications/{modification}', 'ModificationsController@destroy');

Route::get('/modifications/edit/{modification}', 'ModificationsController@edit')->name('edit.modification');

Route::get('/modifications/view/{modification}', 'ModificationsController@show')->name('show.modification');

Route::patch('/modifications/update/{id}', 'ModificationsController@update');