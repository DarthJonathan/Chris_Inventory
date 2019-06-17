<?php

namespace App\Helpers;

use App\Customers;

class CustomersUtil
{
    public static function findCustomer(String $customer) {
        //Remove every stuff
        str_replace(['.', ','], ' ', $customer);

        $searchTerm = explode(" ", $customer);

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