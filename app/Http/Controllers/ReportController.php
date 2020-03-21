<?php

namespace App\Http\Controllers;

use App\Customers;
use App\Datamodels\Report;
use App\Datamodels\ReportExcel;
use App\Excel\YearlyReport;
use App\Helpers\CarbonHelper;
use App\Helpers\CustomersUtil;
use App\Helpers\InventoryLogger;
use App\Helpers\ProductUtil;
use App\Helpers\Queue;
use App\Helpers\StringUtil;
use App\Products;
use App\Purchase;
use App\Sales;
use App\TaxInvoice;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Datamodels\CommonEnums;

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
     * @return Collection
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
                $report_new = new Report();

                $report_new->setDate($purchase->transaction_date);
                $report_new->setInvoiceId($purchase->invoice_id);
                $report_new->setTaxInvoiceId($purchase->tax_invoice_id);
                $report_new->setProductName($item->product->product_name);
                $report_new->setQuantity($item->quantity);
                $report_new->setDiscount($item->discount);
                $report_new->setPrice($item->price);

                $customer = CustomersUtil::getCustomerName($purchase->customer_id);
                $report_new->setCustomer($customer);

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
     * Returns a yearly transaction report based on type
     *
     * @param String $type
     * @param int $year
     * @return Collection
     */
    public function composesYearlyTransactionReport(String $type, int $year) {
        $report = collect([]);

        Transaction::where('type', strtolower($type))
            ->whereYear('transaction_date', '=', Carbon::parse('01-01-' . $year)->year)
            ->chunk(300, function($transactions) use ($type, $report) {
                foreach($transactions as $transaction) {
                    if(strcasecmp($type, CommonEnums::SALES) == 0) {
                        foreach($transaction->sales as $item) {
                            $report_new = new Report();

                            $report_new->setDate($transaction->transaction_date);
                            $report_new->setInvoiceId($transaction->invoice_id);
                            $report_new->setTaxInvoiceId($transaction->tax_invoice_id);

                            $product = Products::find($item->product_id);

                            $report_new->setProductName($product->product_name);
                            $report_new->setQuantity($item->quantity);
                            $report_new->setDiscount($item->discount);
                            $report_new->setPrice($item->price);

                            $customer = CustomersUtil::getCustomerName($transaction->customer_id);
                            $report_new->setCustomer($customer);

                            //Tax Invoice
                            $taxInvoice = new \App\Datamodels\TaxInvoice();
                            $loadedTaxInvoice = TaxInvoice::find($transaction->tax_invoice_id);

                            if($loadedTaxInvoice == null) {
                                $taxInvoice->credited_date = null;
                                $taxInvoice->date = null;
                                $taxInvoice->tax_invoice_no = null;
                                $taxInvoice->id = $transaction->tax_invoice_id;
                            }else {
                                $taxInvoice->credited_date = $loadedTaxInvoice->credited;
                                $taxInvoice->date = $loadedTaxInvoice->date;
                                $taxInvoice->tax_invoice_no = $loadedTaxInvoice->invoice_no;
                                $taxInvoice->id = $transaction->tax_invoice_id;
                            }

                            $report_new->setTaxInvoice($taxInvoice);
                            $report->add($report_new);
                        }
                    }else {
                        foreach($transaction->purchases as $item) {
                            $report_new = new Report();

                            $report_new->setDate($transaction->transaction_date);
                            $report_new->setInvoiceId($transaction->invoice_id);
                            $report_new->setTaxInvoiceId($transaction->tax_invoice_id);

                            $product = Products::find($item->product_id);

                            $report_new->setProductName($product->product_name);
                            $report_new->setQuantity($item->quantity);
                            $report_new->setDiscount($item->discount);
                            $report_new->setPrice($item->price);

                            $customer = CustomersUtil::getCustomerName($transaction->customer_id);
                            $report_new->setCustomer($customer);

                            //Tax Invoice
                            $taxInvoice = new \App\Datamodels\TaxInvoice();
                            $loadedTaxInvoice = TaxInvoice::find($transaction->tax_invoice_id);

                            if($loadedTaxInvoice == null) {
                                $taxInvoice->credited_date = null;
                                $taxInvoice->date = null;
                                $taxInvoice->tax_invoice_no = null;
                                $taxInvoice->id = $transaction->tax_invoice_id;
                            }else {
                                $taxInvoice->credited_date = $loadedTaxInvoice->credited;
                                $taxInvoice->date = $loadedTaxInvoice->date;
                                $taxInvoice->tax_invoice_no = $loadedTaxInvoice->invoice_no;
                                $taxInvoice->id = $transaction->tax_invoice_id;
                            }

                            $report_new->setTaxInvoice($taxInvoice);
                            $report->add($report_new);
                        }
                    }
                }
            });

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
        $report = $this->reportsToArray(
                        $this->transformExcelReport(
                            $this->composesYearlyTransactionReport($type, $year)
                        )
                    );
        try {
            return Excel::create('Year ' . $year . ' Report', function($excel) use ($report, $type) {
                // Set the spreadsheet title, creator, and description
                $excel->setTitle($type . ' Report');
//                $excel->setCreator('Laravel')->setCompany('WJ Gilmore, LLC');
//                $excel->setDescription('payments file');

                // Build the spreadsheet, passing in the payments array
                $excel->sheet(ucfirst($type) . ' Report', function($sheet) use ($report) {
                    $sheet->fromArray($report, null, 'A1', false, false);
                });
            })->download('xlsx');
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
        $report = $this->reportsToArray(
                        $this->transformExcelReport(
                            $this->composesMonthlyTransactionReport($type, $month)
                        )
                    );
        try {
            return Excel::create('Month ' . $month . ' Report', function($excel) use ($report, $type) {
                // Set the spreadsheet title, creator, and description
                $excel->setTitle($type . ' Report');
//                $excel->setCreator('Laravel')->setCompany('WJ Gilmore, LLC');
//                $excel->setDescription('payments file');

                // Build the spreadsheet, passing in the payments array
                $excel->sheet(ucfirst($type) . ' Report', function($sheet) use ($report) {
                    $sheet->fromArray($report, null, 'A1', false, false);
                });
            })->download('xlsx');
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
            $report_excel_singular->setCustomer($report_singular->customer);

            $report_excel->add($report_excel_singular);
        }
        return $report_excel;
    }

    /**
     * Morph reports from ReportExcel to array
     * @param Collection $excelReports
     * @return Collection
     */
    private function reportsToArray(Collection $excelReports) : Collection {
        $reports = new Collection();
        foreach($excelReports as $report) {
            $reports->add($report->toArray());
        }

        //Gets the attribute of class
        $report = new ReportExcel();
        $reports->prepend($report->getAttributes());

        return $reports;
    }

    /**
     * Import View
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function importReportView () {
        return view('reports.import');
    }

    /**
     * Uploaded file preview
     * @param Request $req
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function importReport (Request $req) {
        $req->validate([
            'type'      => 'required',
            'import'    => 'required|mimes:xls,xlsx,xlsm'
        ]);

        $import = $req->file('import');
        $array = Excel::load($import, function($reader) {
            $reader->calculate();
        })->toArray();

        $reports = new Collection();

        try {
            if($req->type == "sales") {
                foreach ($array as $item) {
                    $report = new Report();

                    $report->setDate($item['date']);
                    $report->setInvoiceId($item['invoice_no.']);
                    $report->setProductName($item['product_name']);
                    $report->setQuantity($item['quantity']);
                    $report->setDiscount($item['discount_incl._vat']);
                    $report->setPrice($item['price_incl._vat']);
                    $report->setCustomer($item['customer_name']);

                    //No taxes
                    $report->setTaxInvoice(null);
                    $report->setTaxInvoiceId(null);

                    $reports->add($report);
                }
            }else {
                foreach ($array as $item) {
                    $report = new Report();

                    $report->setDate($item['date']);
                    $report->setInvoiceId($item['invoice_no.']);
                    $report->setProductName($item['product_name']);
                    $report->setQuantity($item['quantity']);
                    $report->setPrice($item['price_incl._vat']);
                    $report->setDiscount($item['discount_incl._vat']);

                    if(array_key_exists('tax_invoice_no.', $item)) {
                        //Check if tax invoice exists
                        $taxInvoice = TaxInvoice::where('invoice_no', $item['tax_invoice_no.'])
                            ->first();

                        if($taxInvoice == null) {
                            $taxInvoice = new TaxInvoice();
                            $taxInvoice->invoice_no = $item['tax_invoice_no.'];
                        }

                        $taxInvoice->date = $item['tax_invoice_date'];

                        //If it's already credited
                        if($item['credited_in_vat_period'] != null) {
                            $taxInvoice->credited = Carbon::parse(CarbonHelper::replaceMonthToEnglish($item['credited_in_vat_period']));
                            $taxInvoice->used = true;
                        }else {
                            $taxInvoice->date = null;
                            $taxInvoice->credited = null;
                            $taxInvoice->used = false;
                        }

                        $taxInvoice->is_active = true;

                        $report->setTaxInvoice($taxInvoice);
                        $report->setTaxInvoiceId($taxInvoice->id);
                    }else {
                        $report->setTaxInvoiceId(null);
                        $report->setTaxInvoice(null);
                    }

//                    $customer_info['depo'] = $item['depo'];
//                    $customer_info['no_kendaraan'] = $item['no_kendaraan'];
//                    $customer_info['driver'] = $item['driver'];
//                    $customer_info['payment'] = $item['payment'];

                    $reports->add($report);
                }
            }
        }catch (\Exception $e) {
            return back()->withErrors('Error importing data in : ' .  $e->getMessage());
        }

        //Store the reports in session
        Session::put('uploaded_report', $reports);
        Session::put('report_type', $req->type);

        return view('reports.uploaded', ['reports' => $reports]);
    }

    /**
     * Handle the import to the database
     */
    public function handleImportToDatabase() {
        $imports    = Session::get('uploaded_report');
        $type       = Session::get('report_type');

        try {
            foreach ($imports as $import) {
                $imported_customer_name = CustomersUtil::findCustomer($import->getCustomer());
                $imported_item_name = ProductUtil::findProduct($import->getProductName());

                //if null then create new record
                if ($imported_item_name == null) {
                    $newProduct = new Products();
                    $newProduct->product_name = $import->getProductName();
                    $newProduct->description = $import->getProductName();
                    $newProduct->stock = 0;
                    $newProduct->queue_stock = 0;
                    $newProduct->queue_id = 0;
                    $newProduct->is_active = true;
                    $newProduct->save();
                }

                if ($imported_customer_name == null) {
                    $newCustomer = new Customers();
                    $newCustomer->name = $import->getCustomer();
                    $newCustomer->is_active = true;

//                    $customer_details = [];
//                    dd($imports);
//
//                    $customer_details['depo'] = $import['depo'];
//                    $customer_details['no_kendaraan'] = $import['no_kendaraan'];
//                    $customer_details['driver'] = $import['driver'];
//                    $customer_details['payment'] = $import ['payment'];
//
//                    $newCustomer->details = json_encode($customer_details);
                    $newCustomer->save();

//                    dd($newCustomer);
                }

                if ($type == 'sales')
                    $this->importSales($import);
                else
                    $this->importPurchase($import);
            }
            return redirect('/import')->with('success', 'Importing success');

        }catch(\Exception $e) {
            return back()->withErrors("Error creating new record (Error : " . $e->getMessage() . " )");
        }
    }

    /**
     * Import the purchases
     * @param Report $report
     * @return \Illuminate\Http\RedirectResponse
     */
    private function importPurchase (Report $report) {
            $transaction = Transaction::where('type', CommonEnums::PURCHASE())
                ->where('invoice_id', $report->getInvoiceId())
                ->where('transaction_date', $report->getDate())
                ->first();

            if($transaction == null) {
                $transaction = new Transaction();
                $transaction->type = CommonEnums::PURCHASE();
                $transaction->invoice_id = $report->getInvoiceId();
                $transaction->transaction_date = $report->getDate();
                $transaction->save();
            }

            $tax_invoice = null;

            if($report->getCustomer() != null) {
                $customer = CustomersUtil::findCustomer($report->getCustomer());
                $transaction->customer_id = $customer != null ? $customer->id : null;
            }

            $purchase = new Purchase();
            $purchase->transaction_id = $transaction->id;
            $purchase->price = $report->getPrice();

            if($report->getCustomer() != null) {
                $customer = CustomersUtil::findCustomer($report->getCustomer());
                $transaction->customer_id = $customer != null ? $customer->id : null;
            }

            if($report->getProductName() != null) {
                $product = $report->getProductName();
                $product = ProductUtil::findProduct($product);
                $purchase->product_id = $product != null ? $product->id : null;
            }

            $purchase->discount = $report->getDiscount();
            $purchase->quantity = $report->getQuantity();

            $purchase->save();

            //Changes the stock and average price
            $inventory = Products::find($purchase->product_id);
            //Set as the lifo if calculation finished
            if($inventory->queue_id == null) {
                $inventory->queue_id = $purchase->id;
                $inventory->queue_stock = $purchase->quantity;
                $inventory->stock = $purchase->quantity;
            }else {
                $inventory->stock += $purchase->quantity;
            }
            $inventory->save();

            //Save the inventory to log
            InventoryLogger::saveNewLog($inventory, $transaction);
            $transaction->save();
    }

    /**
     * Import the sales
     * @param Report $report
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    private function importSales(Report $report) {
        try {
            $transaction = Transaction::where('type', CommonEnums::SALES())
                            ->where('invoice_id', $report->getInvoiceId())
                            ->where('transaction_date', $report->getDate())
                            ->first();

            if($transaction == null) {
                $transaction = new Transaction();
                $transaction->type = CommonEnums::SALES();
                $transaction->invoice_id = $report->getInvoiceId();
                $transaction->transaction_date = $report->getDate();
                $transaction->save();
            }

            $tax_invoice = null;

            $sale = new Sales();
            $sale->transaction_id = $transaction->id;
            $sale->price = $report->getPrice();

            if($report->getCustomer() != null) {
                $customer = CustomersUtil::findCustomer($report->getCustomer());
                $transaction->customer_id = $customer != null ? $customer->id : null;
            }

            if($report->getProductName() != null) {
                $product = $report->getProductName();
                $product = ProductUtil::findProduct($product);
                $sale->product_id = $product != null ? $product->id : null;
            }

            $sale->discount = $report->getDiscount();
            $sale->quantity = $report->getQuantity();
            $sale->sales_date = $report->getDate();

            $sale->save();

            //Changes the stock and average price
            $inventory = Products::find($sale->product_id);
            Queue::takeoutItems($inventory, $sale->quantity);
            $inventory->save();

            //Save the inventory to log
            InventoryLogger::saveNewLog($inventory, $transaction);
            $transaction->save();
        }catch(\Exception $e) {
            return back()->withErrors("Error creating new record (Error : " . $e->getMessage() . " )");
        }
    }

    /**
     * Home page of application
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function homeStats() {
        $total_transactions = Transaction::whereYear('transaction_date', Carbon::now())->count();
        $total_transactions_last_year = Transaction::whereYear('transaction_date', Carbon::now()->subYear())->count();
        $transaction_decrease = $total_transactions_last_year == 0 ? 0 : 100 - ($total_transactions/$total_transactions_last_year * 100);
        $data = [
            'total_transaction'   => Transaction::whereYear('transaction_date', Carbon::now())->count(),
            'total_transaction_decrease'    => $transaction_decrease,
            'total_sales'  => Transaction::where('type', 'Sales')->count(),
            'total_purchases'  => Transaction::where('type', 'Purchases')->count()
        ];
        return response($data,200);
    }

    /**
     * Yearly sales api
     * @param $year
     * @param $page
     * @return mixed
     */
    public function yearlySalesApi($year, $page) {
        return Transaction::where('type', CommonEnums::SALES())
            ->whereYear('transaction_date', '=', $year)
            ->with('sales')
            ->offset(($page-1)*300)
            ->limit(300)
            ->get()
            ->toJson();
    }

    /**
     * Yearly purchase api
     * @param $year
     * @param $page
     * @return mixed
     */
    public function yearlyPurchaseApi($year, $page) {
        return Transaction::where('type', CommonEnums::PURCHASE())
            ->whereYear('transaction_date', '=', $year)
            ->with('purchases')
            ->offset(($page-1)*300)
            ->limit(300)
            ->get()
            ->toJson();
    }

    public function monthlySalesApi($month, $year, $page) {
        return Transaction::where('type', CommonEnums::SALES())
            ->whereYear('transaction_date', '=', $year)
            ->whereMonth('transaction_date', '=', $month)
            ->with('sales')
            ->offset(($page-1)*300)
            ->limit(300)
            ->get()
            ->toJson();
    }

    public function monthlyPurchaseApi($month, $year, $page) {
        return Transaction::where('type', CommonEnums::PURCHASE())
            ->whereYear('transaction_date', '=', $year)
            ->whereMonth('transaction_date', '=', $month)
            ->with('purchases')
            ->offset(($page-1)*300)
            ->limit(300)
            ->get()
            ->toJson();
    }
}
