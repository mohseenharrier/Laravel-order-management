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

Route::get('/', 'orderController@index');

Auth::routes();

Route::get('/home', 'orderController@index')->name('orders');

Route::delete('orders/delete/{id}', 'orderController@deleteOrder');
Route::resource('orders', 'orderController');



