<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchasesController extends Controller
{

    /**
     * Overview for all purchases
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function overview() {
        return view('/purchase/overview');
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
            $purchase = new Purchase();

            $purchase->product_id = $req->product;
            $purchase->invoice = $req->invoice;
            $purchase->quantity = $req->quantity;
            $purchase->price = $req->price;
            $purchase->discount = $req->discount;
            $purchase->purchase_date = $req->date;

            $purchase->save();
            return redirect('/purchases')->with('success', 'Success adding new purchase');
        }catch(\Exception $e) {
            return redirect('/purchases')->withErrors($e->getMessage());
        }
    }
}
