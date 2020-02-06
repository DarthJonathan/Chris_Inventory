<?php

namespace App\Http\Controllers;

use App\Customers;
use App\Products;
use App\TaxInvoice;

class ApiController extends Controller
{
    /**
     * Get all products
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts() {
        return response()->json(Products::where('is_active', 1)->get());
    }

    /**
     * Get all tax invoices
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTaxInvoices() {
        return response()->json(TaxInvoice::all());
    }

    /**
     * Get all customers api call
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllCustomers() {
        return response()->json(Customers::where('is_active', 1)->get());
    }

    /**
     * Handle all customer api from datatables
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllCustomersDatatables() {
        return datatables(Customers::where('is_active', 1)->get())->toJson();
    }
}
