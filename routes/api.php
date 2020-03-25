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

Route::middleware('jwt.auth')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('jwt.auth')->group(function() {
    Route::prefix('/invoice')->group(function() {
       Route::put('/new', 'InvoiceController@exportInvoice');
    });

    Route::get('/items', 'ProductsController@allItemsApi');

    Route::prefix('/report')->group(function(){
        Route::get('/yearly/sales/{year}', 'ReportController@yearlySalesApi');
        Route::get('/yearly/purchases/{year}', 'ReportController@yearlyPurchaseApi');

        Route::get('/monthly/sales/{month}/{year}', 'ReportController@monthlySalesApi');
        Route::get('/monthly/purchases/{month}/{year}', 'ReportController@monthlyPurchaseApi');

        Route::get('/home_stat', 'ReportController@homeStats');
    });
});

Route::post('login', 'ApiTokenController@signIn');
