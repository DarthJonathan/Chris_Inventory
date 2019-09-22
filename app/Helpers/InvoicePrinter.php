<?php


namespace App\Helpers;


use Illuminate\Support\Facades\File;

class InvoicePrinter
{
    private static $invoiceTemplate = 'Templates/Invoice.txt';

    public static function generateInvoice() {
        $path = app_path(InvoicePrinter::$invoiceTemplate);
        $invoiceTemplate = File::get($path);
        dd($invoiceTemplate);
    }
}
