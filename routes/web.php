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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('api/v1')->group(function(){
   Route::get('products', 'ApiController@getProducts');
});

Route::prefix('purchases')->group(function() {
    Route::get('/', 'PurchasesController@overview');
    Route::get('new', 'PurchasesController@newView');
    Route::post('new', 'PurchasesController@newSubmit');
    Route::get('details/{id}', 'PurchasesController@purchaseDetail');
    Route::get('edit/{id}', 'PurchasesController@editView');
    Route::post('edit', 'PurchasesController@handleEditPurchase');
    Route::post('delete', 'PurchasesController@deletePurchase');
});

Route::prefix('products')->group(function() {
    Route::get('/', 'ProductsController@overview');
    Route::get('/new', 'ProductsController@newView');
    Route::post('/new', 'ProductsController@newSubmit');
    Route::get('/edit/{id}', 'ProductsController@editItemView');
    Route::post('/edit', 'ProductsController@editSubmit');
    Route::post('/delete', 'ProductsController@deleteItem');
});

Route::prefix('sales')->group(function(){
    Route::get('/', 'SalesController@list');
    Route::get('/new', 'SalesController@newView');
    Route::post('/new', 'SalesController@handleNew');
});