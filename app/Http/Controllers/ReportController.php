<?php

namespace App\Http\Controllers;

use App\Datamodels\Report;
use App\Excel\YearlyReport;
use App\TaxInvoice;
use App\Transaction;
use Carbon\Carbon;

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

    /**
     * Monthly
     *
     * @param String $parameter
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
     * Monthly datatables
     *
     * @param String $type
     * @param int $year
     * @return \Illuminate\Http\JsonResponse
     */
    public function monthlyDatatables(String $type, int $month) {
        return datatables($this->composesMonthlyTransactionReport($type, $month))->toJson();
    }

    /**
     * Creates a monthly transaction report
     *
     * @param String $type
     * @param int $monthNumber
     * @return \Illuminate\Support\Collection
     */
    public function composesMonthlyTransactionReport(String $type, int $monthNumber){
        $report = collect([]);
        $year_now = Carbon::now()->year;

        $purchases = Transaction::where('type', $type)
            ->whereYear('transaction_date', '=', $year_now)
            ->whereMonth('transaction_date', '=', Carbon::parse('01-' . ($monthNumber+1) . '-' . $year_now))
            ->get();

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

    /**
     * Returns a yearly transaction report based on type
     *
     * @param String $type
     * @param int $year
     * @return \Illuminate\Support\Collection
     */
    public function composesYearlyTransactionReport(String $type, int $year) {
        $report = collect([]);

        $purchases = Transaction::where('type', $type)
                        ->whereYear('transaction_date', '=', Carbon::parse('01-01-' . $year)->year)
                        ->get();

        foreach($purchases as $purchase) {
            foreach($purchase->purchases as $item) {
                $report_new = new Report();

                $report_new->setDate($purchase->transaction_date);
                $report_new->setInvoiceId($purchase->invoice_id);
                $report_new->setTaxInvoiceId($purchase->tax_invoice_id);
                $report_new->setProductName($item->product->product_name);
                $report_new->setQuantity($item->quantity);
                $report_new->setDiscount($item->discount);
                $report_new->setPrice($item->price);

                //Tax Invoice
                $taxInvoice = new \App\Datamodels\TaxInvoice();
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

                $report_new->setTaxInvoice($taxInvoice);
                $report->add($report_new);
            }
        }

        return $report;
    }


    public function exportYearly(String $type, int $year) {
        if($type != 'purchase' && $type != 'sales'){
            abort(404);
        }

        //Composes the report
        $report = $this->composesYearlyTransactionReport($type, $year);

        try {
            return (new YearlyReport($report))->download('Yearly.xlsx');
        }catch (\Exception $e) {
            dd($e);
        }
        return false;
    }
}
