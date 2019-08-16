<?php

namespace App\Helpers;

use App\Products;

class ProductUtil
{
    /**
     * Find product by name
     * @param String $product
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model Product Model
     */
    public static function findProduct(String $product) {
        //Remove every stuff
        $query = Products::query();
        $query->where('product_name', 'like', '%' . $product . '%');
        return $query->first();
    }
}
