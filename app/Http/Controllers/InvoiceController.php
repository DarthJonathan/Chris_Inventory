<?php

namespace App\Http\Controllers;

use App\Datamodels\InvoiceItem;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * New invoice page
     */
    public function newInvoice() {
        return view('invoice.invoice');
    }

    public function exportInvoice(Request $request) {
        $sale = [];

        foreach($request->item as $key => $item) {
            $invoice_item = new InvoiceItem();
            $invoice_item->setDiscount($request->discount[$key]);
            $invoice_item->setItemName($request->item[$key]);
            $invoice_item->setPrice($request->price[$key]);
            $invoice_item->setQuantity($request->quantity[$key]);

            array_push($sale, $invoice_item);
        }

        $data = [
            'items'         => $sale,
            'date'          => $request->date,
            'invoice_id'    => $request->invoice
        ];
        return view('invoice.template', $data);
    }
}
