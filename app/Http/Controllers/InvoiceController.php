<?php

namespace App\Http\Controllers;

use App\Datamodels\InvoiceItem;
use App\Helpers\InvoicePrinter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    /**
     * Export Invoice for API
     * @param Request $request
     * @return false|string
     */
    public function exportInvoice(Request $request) {
        $sale = [];
        $rules = [
            'items'         => 'required|array|min:1',
            'txnDate'       => 'required',
            'customer_id'   => 'nullable|numeric'
        ];

        $validate = Validator::make($request->all(), $rules);

        if($validate->fails()) {
            return response(['Errors' => $validate->getMessageBag()], 400);
        }

        foreach($request->items as $key => $item) {
            $invoice_item = new InvoiceItem();
            $invoice_item->setItemId($item['id']);
            $invoice_item->setItemName($item['name']);
            $invoice_item->setPrice($item['price']);
            $invoice_item->setQuantity($item['quantity']);
            $invoice_item->setDiscount(array_key_exists('discount', $item) ? $item['discount'] : 0);
            array_push($sale, $invoice_item);
        }

        $data = [
            'items'         => $sale,
            'biz_date'      => Carbon::now(),
            'txn_date'      => Carbon::parse($request->txnDate),
            'customer_id'   => $request->customer_id
        ];

        return response(InvoicePrinter::generateInvoice($data));
    }
}
