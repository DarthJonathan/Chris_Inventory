<?php


namespace App\Helpers;


use App\Products;
use App\Sales;
use App\Transaction;
use Carbon\Carbon;

class InvoicePrinter
{
    /**
     * Generate Invoice from app
     * @param $data
     * @return Transaction|\Exception
     */
    public static function generateInvoice($data) {
        try {
            //Get the previous day invoice
            $last_today = Sales::whereDate('created_at', Carbon::today())->get()->count();
            $invoice_number = 'INV-' . $data['biz_date']->format('md') . '-' . str_pad($last_today, 3, STR_PAD_LEFT) . '-' . $data['biz_date']->format('y');

            $transaction = new Transaction();
            $transaction->type = "Sales";
            $transaction->invoice_id = $invoice_number;
            $transaction->transaction_date = $data['txn_date'];
            $transaction->save();

            if(array_key_exists('customer_id', $data)) {
                $transaction->customer_id = $data['customer_id'];
            }

            foreach($data['items'] as $item) {
                $sale = new Sales();
                $sale->transaction_id       = $transaction->id;
                $sale->price                = $item->getPrice();
                $sale->product_id           = $item->getItemId();
                $sale->discount             = $item->getDiscount();
                $sale->quantity             = $item->getQuantity();
                $sale->sales_date           = $data['txn_date'];
                $sale->save();

                //Changes the stock and average price
                $inventory = Products::find($sale->product_id);
                Queue::takeoutItems($inventory, $sale->quantity);
                $inventory->save();
            }

            return $transaction;
        }catch(\Exception $e) {
            return $e;
        }
    }
}
