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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => ['role:admin' || 'super admin']], function () {
    //ADMIN PAGE..
	Route::get('/admin_page', 'admin_page@index');
	Route::post('/admin_page/add_item', 'admin_page@insert_item');
	Route::post('/admin_page/update_item', 'admin_page@update_item');
	Route::get('/admin_page/{id}', 'admin_page@delete_item');
});

Route::group(['middleware' => ['role:user' || 'super admin']], function () {
	//USER PAGE..
	Route::get('/user_page', 'user_page@index');
	Route::get('/user_page/item_id', 'user_page@show_item');
	Route::get('/user_page/item_cart_id', 'user_page@cart_item');
	Route::post('/user_page/quantity_update', 'user_page@quantity_update');
	Route::post('/user_page/add_to_cart', 'user_page@store_to_session_cart');
	//CART PAGE..
	Route::get('/cart_page', 'cart_page@index');
	Route::post('/cart_page/add_cart_item', 'cart_page@insert_cart_item');
	Route::get('/cart_page/{id}', 'cart_page@delete_cart_item');
	Route::post('/cart_page/item_id', 'cart_page@display_item');
	Route::post('/cart_page/quantity_update', 'cart_page@quantity_update');
	Route::get('/cart/remove', 'cart_page@remove');
});

// Route::group(['middleware' => ['role:super admin']], function () {
	Route::get('/superAdmin_page', 'superAdmin_page@index');
	Route::post('/superAdmin_page/register_user', 'superAdmin_page@register_user');
	Route::post('/superAdmin_page/update_user', 'superAdmin_page@update_user');
	Route::post('/superAdmin_page/delete_user', 'superAdmin_page@delete_user');
	
	Route::post('/add_role_page/add_role', 'add_role_page@add_role');
	Route::get('/add_role_page', 'add_role_page@index');
	Route::post('/add_role_page/update_role', 'add_role_page@update_role');
	Route::post('/add_role_page/delete_role', 'add_role_page@delete_role');
// });