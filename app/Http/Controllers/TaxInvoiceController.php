<?php

namespace App\Http\Controllers;

use App\TaxInvoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class TaxInvoiceController extends Controller
{

    /**
     * Tax Invoice overview
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function overview() {
        return view('taxinvoices.overview');
    }

    /**
     * Get all tax invoices for datatables ajax
     *
     * @return \Yajra\DataTables\DataTableAbstract|\Yajra\DataTables\DataTables
     */
    public function overviewDatatables() {
        return datatables(TaxInvoice::all())->toJson();
    }

    /**
     * New tax invoice view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newView() {
        return view('taxinvoices.new');
    }

    /**
     * Handle creating new tax invoices record
     * @param Request $req
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleNew (Request $req) {
        $rules = [
            'invoiceno' => 'required',
            'date'      => 'required',
            'cashed'    => 'required',
            'customer'  => 'nullable|numeric'
        ];

        $validator = Validator::make($req->all(), $rules);

        if($validator->fails()) {
            return redirect('/taxinvoices/new')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $customer = new TaxInvoice();

            $customer->invoice_no = $req->invoiceno;
            $customer->date = Carbon::parse($req->date);
            $customer->used = $req->cashed ? 1 : 0;

            if($req->cashed){
                $customer->credited = Carbon::now();
            }

            $customer->is_active = true;

            $customer->save();
            return redirect('/taxinvoices')->with('success', 'Success adding a new Tax Invoice');
        }catch(\Exception $e){
            return back()->withErrors("Error, (" . $e->getMessage() . ")");
        }
    }

    /**
     * Edit Tax Invoice view
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editItemView($id) {
        $item = TaxInvoice::find($id);
        $data = [
            'taxinvoice'  =>  $item
        ];
        return view('taxinvoices.edit', $data);
    }

    /**
     * Handle edit tax invoice
     * @param Request $req
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editSubmit(Request $req) {
        $rules = [
            'id'        => 'required',
            'invoiceno' => 'required',
            'date'      => 'required',
            'cashed'    => 'required',
            'customer'  => 'nullable|numeric'
        ];

        $validator = Validator::make($req->all(), $rules);

        if($validator->fails()) {
            return redirect('/taxinvoices/edit/' . $req->id)
                ->withErrors($validator)
                ->withInput();
        }

        try {

            return redirect('/customers')->with('success', 'Success saving customer data');
        }catch(\Exception $e){
            return back()->withErrors("Error, (" . $e->getMessage() . ")");
        }
    }

    /**
     * Delete tax invoice
     * @param Request $req
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteItem (Request $req) {
        try {
            $id = $req->id;

            //Check for product occurance
            $transactions = Transaction::where('customer_id', $id)->get();

            if($transactions->count() > 0) {
                return back()->withErrors("Customer is used for transactions");
            }

            $product = Customers::find($id);
            $product->is_active = false;

            $product->save();
            return back()->with('success', 'Customer Deletion Success!');
        }catch(\Exception $e) {
            return back()->withErrors("Error, ( " . $e->getMessage() . " )");
        }
    }

    /**
     * Yearly tax invoice view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function yearlyTaxInvoice () {
        return view('taxinvoices.overview');
    }

    /**
     * Get current year tax invoice
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function yearlyTaxInvoiceDatatables() {
        $now = new Carbon();
        return datatables(TaxInvoice::whereYear('created_at', $now->year)->get())->toJson();
    }

    /**
     * Detail of a tax invoice
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id) {
        $data = [
            'tax_invoice'  => TaxInvoice::find($id)
        ];
        return view('TaxInvoices.details', $data);
    }
}
