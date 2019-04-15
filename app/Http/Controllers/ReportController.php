<?php

namespace App\Http\Controllers;

use App\TaxInvoice;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Yearly report view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function yearly(String $parameter) {
        if($parameter != 'purchase' && $parameter != 'sales'){
            abort(404);
        }

        $data = [
            'type'  => $parameter
        ];
        return view('reports.yearly', $data);
    }

    /**
     * Yearly report datatable
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function yearlyDatatables(String $type, int $year) {
        return datatables($this->composesYearlyTransactionReport($type, $year))->toJson();
    }

    public function monthly(String $parameter) {
        if($parameter != 'purchase' && $parameter != 'sales'){
            abort(404);
        }

        $data = [
          'type'    => $parameter
        ];
        return view('reports.monthly', $data);
    }

    /**
     * Returns a yearly report transaction
     *
     * @param $year
     * @return \Illuminate\Support\Collection of report
     */
    public function composesYearlyTransactionReport(String $type, int $year) {
        $report = collect([]);

        $purchases = Transaction::where('type', $type)->whereYear('transaction_date', '=', Carbon::parse('01-01-' . $year)->year)->get();

        foreach($purchases as $purchase) {
            foreach($purchase->purchases as $item) {
                $report_new = new \stdClass();

                $report_new->date           = $purchase->transaction_date;
                $report_new->invoice_id     = $purchase->invoice_id;
                $report_new->tax_invoice_id = $purchase->tax_invoice_id;
                $report_new->product_name   = $item->product->product_name;
                $report_new->quantity       = $item->quantity;
                $report_new->discount       = $item->discount;
                $report_new->price          = $item->price;

                //Tax Invoice
                $taxInvoice = new \stdClass();
                $loadedTaxInvoice = TaxInvoice::find($purchase->tax_invoice_id);

                if($loadedTaxInvoice == null) {
                    $taxInvoice->credited_date = null;
                    $taxInvoice->date = null;
                    $taxInvoice->tax_invoice_no = null;
                    $taxInvoice->id = $purchase->tax_invoice_id;
                }else {
                    $taxInvoice->credited_date = $loadedTaxInvoice->credited;
                    $taxInvoice->date = $loadedTaxInvoice->date;
                    $taxInvoice->tax_invoice_no = $loadedTaxInvoice->invoice_no;
                    $taxInvoice->id = $purchase->tax_invoice_id;
                }

                $report_new->tax_invoice = $taxInvoice;
                $report->add($report_new);
            }
        }

        return $report;
    }
}
