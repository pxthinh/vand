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
Route::get('/algorithm', 'AlgorithmController@Algorithm')->name('algorithm');

Route::get('/login', 'UserController@login')->name('login');
Route::post('/login', 'UserController@store')->name('store-login');
Route::get('/logout', 'UserController@logout')->name('logout');

Route::get('/login-admin', 'AdminController@login')->name('login-admin');
Route::post('/login-admin', 'AdminController@store')->name('store-login-admin');
Route::get('/logout-admin', 'AdminController@logout')->name('logout-admin');


Route::get('/', function () {
    return redirect()->route('list-store');
});
Route::get('/stores','StoreController@index')->name('list-store');
Route::get('/store/fetch_data', 'StoreController@fetchData')->name("fetch-data-store");
Route::post('/add-store','StoreController@addStore')->name('add-store');
Route::get('/detail-store/{id}','StoreController@detailStore')->name('detail-store');
Route::post('/edit-store','StoreController@editStore')->name('edit-store');
Route::post('/delete-store/{id}','StoreController@deleteStore')->name('delete-store');

Route::get('/products/{id}','ProductController@index')->name('list-product');
Route::get('/product/fetch_data', 'ProductController@fetchData')->name("fetch-data-product");
Route::post('/add-product','ProductController@addProduct')->name('add-product');
Route::get('/detail-product/{id}','ProductController@detailProduct')->name('detail-product');
Route::post('/edit-product','ProductController@editProduct')->name('edit-product');
Route::post('/delete-product/{store_id}/{id}','ProductController@deleteProduct')->name('delete-product');

Route::get('/list-products/{store_id}','ProductController@listProduct')->name('products');
Route::get('/list-edit-products/{store_id}','ProductController@listEditProduct')->name('list-edit-products');

Route::get('admin/product','ProductManagerController@index')->name('list-product-admin');
Route::get('admin/product/fetch_data','ProductManagerController@fetchData')->name('fetch-data-product-admin');
Route::get('admin/add','ProductManagerController@create')->name('add-product-admin');
Route::post('admin/add','ProductManagerController@store')->name('store-product-admin');
Route::get('admin/show/{id}','ProductManagerController@show')->name('show-product-admin');
Route::post('admin/edit/{id}','ProductManagerController@edit')->name('edit-product-admin');
Route::post('admin/delete/{id}','ProductManagerController@destroy')->name('destroy-product');