<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function() {
    Route::prefix('/invoice')->group(function() {
       Route::put('/new', 'InvoiceController@exportInvoice');
    });

    Route::get('/items', 'ProductsController@allItemsApi');

    Route::prefix('/report')->group(function(){
        Route::get('/yearly/{parameter}', 'ReportController@yearlyApi');
        Route::get('/monthly/{parameter}', 'ReportController@monthlyApi');
    });
});

Route::post('login', 'ApiTokenController@signIn');
