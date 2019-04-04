<?php

namespace App\Http\Controllers;

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
                $report_new->product_name   = $item->product->product_name;
                $report_new->quantity       = $item->quantity;
                $report_new->discount       = $item->discount;

                $report->add($report_new);
            }
        }

        return $report;
    }
}
