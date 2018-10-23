<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\Purchase;
use App\TaxInvoice;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class PurchasesController extends Controller
{

    /**
     * Overview for all purchases
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function overview() {
        $data = [
            'purchases' => Purchase::paginate(25)
        ];
        return view('/purchase/overview', $data);
    }

    /**
     * New purchase view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newView() {
        return view('/purchase/new');
    }

    /**
     * New purchase submit
     * @param Request $req
     * @return \Illuminate\Http\RedirectResponse
     */
    public function newSubmit(Request $req) {
        try {
            $rules = [
                'date'      => 'required',
                'invoice'   => 'required',
                'item'      => 'required',
                'price'     => 'required',
                'discount'  => 'required'
            ];

            $validation = Validator::make($req->all(), $rules);

            if($validation->fails)
                return back()->withErrors($validation)->withInput();

            $purchase = new Purchase();

            $purchase->product_id = $req->product;
            $purchase->invoice = $req->invoice;
            $purchase->quantity = $req->quantity;
            $purchase->price = $req->price;
            $purchase->discount = $req->discount;
            $purchase->purchase_date = $req->date;

            if($req->taxinvoice != null && $req->taxinvoicedate != null) {
                $tax_invoice = new TaxInvoice();
                $tax_invoice->invoice_no = $req->taxinvoice;
                $tax_invoice->date = $req->taxinvoicedate;
                $tax_invoice->save();

                $purchase->tax_invoice_id = $tax_invoice->id;
            }

            //Changes the stock and average price
            $inventory = Inventory::where('product_id', $req->product_id)->first();
            $inventory->
            $inventory->save();

            $purchase->save();
            return redirect('/purchases')->with('success', 'Success adding new purchase');
        }catch(\Exception $e) {
            return redirect('/purchases')->withErrors($e->getMessage());
        }
    }

    /**
     * Edit Purchase View
     * @param Request $req
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editView(Request $req) {

        $purchase = Purchase::find($req->id);

        $data = [
            'purchase'  => $purchase
        ];
        return View("purchase.edit", $data);
    }

    /**
     * Handle the posted form
     * @param Request $req
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleEditPurchase (Request $req) {
        try {
            $rules = [
                'date'      => 'required',
                'invoice'   => 'required',
                'item'      => 'required',
                'price'     => 'required',
                'discount'  => 'required',
                'id'        => 'required'
            ];

            $validation = Validator::make($req->all(), $rules);

            if($validation->fails)
                return back()->withErrors($validation)->withInput();

            $purchase = Purchase::find($req->id);

            $purchase->product_id = $req->product;
            $purchase->invoice = $req->invoice;
            $purchase->quantity = $req->quantity;
            $purchase->price = $req->price;
            $purchase->discount = $req->discount;
            $purchase->purchase_date = $req->date;

            $purchase->save();
            return redirect('/purchases')->with('success', 'Success saving changes to purchase');

        }catch(\Exception $e) {
            return back()->withErrors("Error saving changes (Error" . $e->getMessage() . ")");
        }
    }

    /**
     * Delete purchase
     * @param Request $req
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletePurchase (Request $req) {
        try {
            $purchase = Purchase::find($req->id);
            $purchase->delete();
            return redirect('/purchases')->with('success', 'Success deleting purchase');
        }catch(\Exception $e) {
            return back()->withErrors("Error deleting purchase (Error" . $e->getMessage() . ")");
        }
    }
}
