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

# Transaction Route
Route::get('/transaction/create', 'HomeController@createTransaction');
Route::post('/transaction', 'HomeController@storeTransaction');
Route::get('/transaction/report', 'HomeController@reportTransaction');
Route::get('/transaction/export', 'HomeController@exportTransaction');

# Customer Route
Route::get('/customer', 'HomeController@listCustomer');
Route::get('/customer/create', 'HomeController@createCustomer');
Route::post('/customer', 'HomeController@storeCustomer');
Route::delete('/customer/{customerId}', 'HomeController@destroyCustomer');

# Data Route
Route::get('/clusters', 'HomeController@clusters');
Route::get('/customers', 'HomeController@customers');
