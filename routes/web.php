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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::prefix('purchases')->group(function() {
    Route::get('/', 'PurchaseController@overview');
    Route::get('new', 'PurchaseController@newView');
    Route::post('new', 'PurcaseController@newSubmit');
    Route::get('edit', 'PurchaseController@editView');
    Route::post('edit', 'PurchaseController@handleEditPurchase');
    Route::post('/')
});

Route::prefix('products')->group(function() {
    Route::get('/', 'ProductsController@overview');
    Route::get('/new', 'ProductsController@newView');
    Route::post('/new', 'ProductsController@newSubmit');
    Route::post('/delete', 'ProductsController@deleteItem');
    Route::get('/edit/{id}', 'ProductsController@editeItemView');
    Route::post('/edit', 'ProductsController@editSubmit');
});
