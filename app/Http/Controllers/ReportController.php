<?php

namespace App\Http\Controllers;

use App\Datamodels\Report;
use App\Datamodels\ReportExcel;
use App\Excel\YearlyReport;
use App\Helpers\StringUtil;
use App\TaxInvoice;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /** @var string Currency */
    private                 $currency = 'rupiah';

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

    /**
     * Export yearly
     * @param String $type
     * @param int $year
     * @return bool|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportYearly(String $type, int $year) {
        if($type != 'purchase' && $type != 'sales'){
            abort(404);
        }

        //Composes the report
        $report = $this->transformExcelReport($this->composesYearlyTransactionReport($type, $year));
        try {
            return (new YearlyReport($report))->download('Year ' . $year . ' Report.xlsx');
        }catch (\Exception $e) {
            return back()->withErrors('Error in exporting report (' . $e->getMessage() . ')');
        }
    }

    /**
     * Export monthly report
     * @param String $type
     * @param int $month
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportMonthly(String $type, int $month) {
        if($type != 'purchase' && $type != 'sales'){
            abort(404);
        }

        //Composes the report
        $report = $this->transformExcelReport($this->composesMonthlyTransactionReport($type, $month));
        try {
            return (new YearlyReport($report))->download('Month ' . $month . ' Report.xlsx');
        }catch (\Exception $e) {
            return back()->withErrors('Error in exporting report (' . $e->getMessage() . ')');
        }
    }

    /**
     * Transform from web report to excel report
     * @param Collection $report
     * @return Collection
     */
    private function transformExcelReport(Collection $report) : Collection {
        $report_excel = Collection::make([]);

        foreach($report as $report_singular) {
            $report_excel_singular = new ReportExcel();

            $report_excel_singular->setPrice($report_singular->price);
            $report_excel_singular->setDiscount(StringUtil::formatMoney($this->currency, $report_singular->discount));
            $report_excel_singular->setQuantity($report_singular->quantity);

            $total          = $report_singular->quantity * ($report_singular->price - $report_singular->discount);
            $tax_base       = $total / 1.1;
            $tax            = $total - $tax_base;

            $report_excel_singular->setTotal(StringUtil::formatMoney($this->currency, $total));
            $report_excel_singular->setVAT(StringUtil::formatMoney($this->currency, $tax));
            $report_excel_singular->setTaxBase(StringUtil::formatMoney($this->currency, $tax_base));
            $report_excel_singular->setProductName($report_singular->product_name);
            $report_excel_singular->setTaxInvoiceId($report_singular->tax_invoice_id);
            $report_excel_singular->setInvoiceId($report_singular->invoice_id);
            $report_excel_singular->setDate($report_singular->date);
            $report_excel_singular->setTaxInvoiceCreditedDate($report_singular->tax_invoice->credited_date);
            $report_excel_singular->setTaxInvoiceDate($report_singular->tax_invoice->id);
            $report_excel_singular->setTaxInvoiceNo($report_singular->tax_invoice->tax_invoice_no);

            $report_excel->add($report_excel_singular);
        }
        return $report_excel;
    }

    /**
     * Import View
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function importReportView () {
        return view('reports.import');
    }

    public function importReport (Request $req) {
        $import = $req->file('import');
        dd($import);
        $array = Excel::toCollection(new ReportExcel, $req->import->path());
    }
}
