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

Route::get('/test', function() {
    return view('home');
});

Route::prefix('api/v1')->group(function(){
   Route::get('products', 'ApiController@getProducts');
   Route::post('tax_invoices', 'ApiController@getTaxInvoices');
   Route::get('customers', 'ApiController@getAllCustomers');
   Route::get('customers_datatables', 'ApiController@getAllCustomersDatatables');
});

Route::prefix('purchases')->group(function() {
    Route::get('/', 'PurchasesController@overview');
    Route::get('/datatables', 'PurchasesController@overviewDatatables');
    Route::get('new', 'PurchasesController@newView');
    Route::post('new', 'PurchasesController@newSubmit');
    Route::get('details/{id}', 'PurchasesController@purchaseDetail');
    Route::get('edit/{id}', 'PurchasesController@editView');
    Route::post('edit', 'PurchasesController@handleEditPurchase');
    Route::post('delete', 'PurchasesController@deletePurchase');
});

Route::prefix('products')->group(function() {
    Route::get('/', 'ProductsController@overview');
    Route::get('/datatables', 'ProductsController@overviewDatatables');
    Route::get('/new', 'ProductsController@newView');
    Route::post('/new', 'ProductsController@newSubmit');
    Route::get('/edit/{id}', 'ProductsController@editItemView');
    Route::post('/edit', 'ProductsController@editSubmit');
    Route::post('/delete', 'ProductsController@deleteItem');
});

Route::prefix('sales')->group(function(){
    Route::get('/', 'SalesController@list');
    Route::get('/datatables', 'SalesController@overviewDatatables');
    Route::get('/new', 'SalesController@newView');
    Route::post('/new', 'SalesController@handleNew');
    Route::get('/details/{id}', 'SalesController@detail');
    Route::get('/edit/{id}', 'SalesController@editView');
    Route::post('/edit', 'SalesController@handleEdit');
});

Route::prefix('customers')->group(function() {
    Route::get('/', 'CustomerController@overview');
    Route::get('/details/{id}', 'CustomerController@details');
    Route::get('/new', 'CustomerController@newView');
    Route::post('/new', 'CustomerController@handleNew');
    Route::get('/edit/{id}', 'CustomerController@editItemView');
    Route::post('/edit', 'CustomerController@editSubmit');
    Route::post('/delete', 'CustomerController@deleteItem');
});

Route::prefix('taxinvoices')->group(function() {
    Route::get('/', 'TaxInvoiceController@overview');
    Route::get('/datatables', 'TaxInvoiceController@overviewDatatables');

    Route::get('/details/{id}', 'TaxInvoiceController@details');

    Route::get('/new', 'TaxInvoiceController@newView');
    Route::post('/new', 'TaxInvoiceController@handleNew');
    Route::get('/edit/{id}', 'TaxInvoiceController@editItemView');
    Route::post('/edit', 'TaxInvoiceController@editSubmit');
    Route::post('/delete', 'TaxInvoiceController@deleteItem');

    Route::get('/year', 'TaxInvoiceController@yearlyTaxInvoice');
});

Route::prefix('report')->group(function(){
    Route::get('/yearly/{parameter}', 'ReportController@yearly');
    Route::get('/yearly/datatables/{type}/{year}', 'ReportController@yearlyDatatables');
    Route::get('/monthly/{parameter}', 'ReportController@monthly');
});