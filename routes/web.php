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

Route::prefix('purchases')->group(function() {
    Route::get('/', 'PurchasesController@overview');
    Route::get('new', 'PurchasesController@newView');
    Route::post('new', 'PurcasesController@newSubmit');
    Route::get('edit', 'PurchasesController@editView');
    Route::post('edit', 'PurchasesController@handleEditPurchase');
    Route::post('delete', 'PurchasesController@deletePurchase');
});

Route::prefix('products')->group(function() {
    Route::get('/', 'ProductsController@overview');
    Route::get('/new', 'ProductsController@newView');
    Route::post('/new', 'ProductsController@newSubmit');
    Route::post('/delete', 'ProductsController@deleteItem');
    Route::get('/edit/{id}', 'ProductsController@editeItemView');
    Route::post('/edit', 'ProductsController@editSubmit');
});