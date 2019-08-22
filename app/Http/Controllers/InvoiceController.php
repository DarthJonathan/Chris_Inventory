<?php

namespace App\Http\Controllers;

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

        dd($request->all());

        $data = [];
        return view('invoice.template', $data);
    }
}
