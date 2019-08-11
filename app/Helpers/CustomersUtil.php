<?php

namespace App\Helpers;

use App\Customers;

class CustomersUtil
{
    /**
     * Find customer by name
     * @param $customer
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model Customer Model
     */
    public static function findCustomer($customer) {
        //Remove every stuff
        str_replace(['.', ','], ' ', $customer);
        $searchTerms = explode(" ", $customer);
        $query = Customers::query();
        foreach($searchTerms as $searchTerm) {
            $query->orWhere('name', 'like', '%' . $searchTerm . '%');
        }
        return $query->first();
    }

    /**
     * Get customer name
     * @param $customerId id customer
     * @return String customer name
     */
    public static function getCustomerName($customerId): String
    {
        if($customerId == null) {
            return '';
        }else {
            $customer = Customers::find($customerId);
            return $customer->name;
        }
    }
}
