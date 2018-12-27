<?php
/**
 * Created by PhpStorm.
 * User: jonathanhosea
 * Date: 2018-12-26
 * Time: 17:53
 */

namespace App\Helpers;

use App\Products;
use App\Purchase;
use Illuminate\Database\Eloquent\Model;
use Mockery\Exception;

class Queue {

    /**
     * Go to the next queue(s) based on the quantity specified
     * @param Products $product
     * @param int $quantity
     * @return bool
     */
    public static function takeoutItems(Products $product, int $quantity) {
        $delta_quantity = $quantity - $product->queue_stock;

        if($delta_quantity > 0) {
            Queue::proceedQueue($product);

            //Call recurisve if still here;
            if($product->queue_stock - $delta_quantity < 0) {

                Queue::takeoutItems($product, $delta_quantity);
            }else {
                $product->queue_stock -= $delta_quantity;
            }
        }else{
            $product->queue_stock -= $quantity;
        }

        return $product->save();
    }

    /**
     * Got to next queue
     * @param Products $product
     * @return bool
     */
    private static function proceedQueue(Products $product) {
        try {
            //Get the next queue in line
            $next_queue = Purchase::where('id', '>', $product->queue_id)
                ->where('product_id', $product->id)
                ->first();

            $product->queue_stock = $next_queue->quantity;
            $product->queue_id = $next_queue->id;

            return $product->save();
        }catch(Exception $e) {
            throw $e;
        }
    }

    public static function putInItemsInPurchase(Products $product, Purchase $purchase, int $quantity) {
        $quantity_delta = $quantity - $purchase->quantity;
        $purchase->quantity = $quantity;

        if($quantity_delta)

        return $product->save();
    }

    public static function backtrackQueue(Products $product) {
        try {
            //Get the next queue in line
            $previous_queue = Purchase::where('id', '<', $product->queue_id)
                ->where('product_id', $product->id)
                ->first();

            $product->queue_stock = $previous_queue->quantity;
            $product->queue_id = $previous_queue->id;

            return $product->save();
        }catch(Exception $e) {
            throw $e;
        }
    }

    /**
     * Check if queue has passed
     * @param Products $product
     * @param Purchase $transaction
     * @return bool
     */
    public static function queueHasPassed(Products $product, Purchase $transaction) {
        if($product->queue_id > $transaction->id)
            return true;
        else
            return false;
    }

}
