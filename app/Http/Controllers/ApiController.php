<?php

namespace App\Http\Controllers;

use App\Products;
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
}
