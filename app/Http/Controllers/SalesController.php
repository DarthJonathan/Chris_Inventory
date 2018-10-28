<?php

namespace App\Http\Controllers;

use App\Products;
use App\Sales;
use App\TaxInvoice;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    /**
     * Get the sales list
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list () {
        $data = [
          'sales'   => Transaction::where('type', 'sales')->paginate(25)
        ];
        return View("sales.overview", $data);
    }

    /**
     * New sale view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newView() {

        $data = [
          'products'    => Products::all()
        ];

        return View('sales.new', $data);
    }

    /**
     * Handle the new sale
     * @param Request $req
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleNew(Request $req) {
        $rules = [
            'price'         => 'required',
            'product_id'    => 'required',
            'discount'      => 'required',
            'sales_date'    => 'required'
        ];

        $validate = Validator::make($req->all(), $rules);

        if($validate->fails())
            return back()->withErrors($validate)->withInput();

        try {
            $today = Carbon::now();

            //Get the previous day invoice
            $last_today = Sales::whereDate('created_at', Carbon::today())->get();
            $invoice_number = 'INV-' . $today->format('md') . '-' . str_pad($last_today, 3, STR_PAD_LEFT) . '-' . $today->format('y');

            $transaction = new Transaction();
            $transaction->type = "sales";
            $transaction->invoice = $invoice_number;
            $transaction->save();

            for($i=0; $i<collect($req->product_id)->count(); $i++){
                $sale = new Sales();
                $sale->price = $req->price[$i];
                $sale->product_id = $req->product_id[$i];
                $sale->discount = $req->discount[$i];
                if ($req->tax_invoice_id != null)
                    $sale->tax_invoice_id = $req->tax_invoice_id;
                $sale->sales_date = $today;

                //Check for tax invoice
                if($req->tax_invoice_id != null) {
                    $sale->tax_invoice_id = $req->tax_invoice_id;
                    $sale->save();
                }else if($req->taxinvoice != null && $req->taxinvoicedate != null) {
                    $tax_invoice = new TaxInvoice();
                    $tax_invoice->invoice_no = $req->taxinvoice;
                    $tax_invoice->date = $req->taxinvoicedate;
                    $tax_invoice->save();

                    $sale->tax_invoice_id = $tax_invoice->id;
                    $sale->save();
                }else {
                    $sale->save();
                }

                //Changes the stock and average price
                $inventory = Products::find($req->product($i));

                $old_stock = $inventory->stock;
                $avg_price = $inventory->average_price;

                $accumulative_price = $old_stock * $avg_price;
                $accumulative_price += $sale->price * $sale->quantity;

                $inventory->stock += $sale->quantity;
                $inventory->average_price = $accumulative_price / $inventory->stock;
                $inventory->save();
            }

            return redirect('/sales')->with('success', 'Success adding new sale data');
        }catch(\Exception $e) {
            return back()->withErrors("Error creating new record (Error : " . $e->getMessage() . " )");
        }
    }
}
