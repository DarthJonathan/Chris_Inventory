<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function newInvoice() {
        return view('invoice.invoice');
    }

    public function exportInvoice() {

    }
}
