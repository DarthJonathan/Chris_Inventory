<?php

namespace App\Http\Controllers;

use App\Products;
use App\TaxInvoice;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Get all products
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts() {
        return response()->json(Products::all());
    }

    /**
     * Get all tax invoices
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTaxInvoices() {
        return response()->json(TaxInvoice::all());
    }
}
