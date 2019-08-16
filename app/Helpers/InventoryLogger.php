<?php

namespace App\Helpers;

use App\InventoryLog;
use App\Products;
use App\Transaction;

class InventoryLogger {

    /**
     * Save a new log to the database
     * @param Products $inventory
     * @param Transaction $transaction
     */
    public static function saveNewLog(Products $inventory, Transaction $transaction) {
        //Save the inventory to log
        $log = new InventoryLog();

        $log->transaction_id = $transaction->id;
        $log->product_id = $inventory->id;
        $log->product_name = $inventory->product_name;
        $log->description = $inventory->description;
        $log->queue_id = $inventory->queue_id;
        $log->stock_in_queue = $inventory->queue_stock;
        $log->price = $inventory->average_price;
        $log->stock = $inventory->stock;
        $log->save();
    }
}
