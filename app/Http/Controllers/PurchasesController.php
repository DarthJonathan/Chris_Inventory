<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\InventoryLog;
use App\Products;
use App\Purchase;
use App\TaxInvoice;
use App\Transaction;
use Illuminate\Http\Request;
use Validator;
use JavaScript;

class PurchasesController extends Controller
{

    /**
     * Overview for all purchases
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function overview() {
        $data = [
            'purchases' => Transaction::where([
                'type'          => 'Purchase',
                'is_active'     => true
            ])->paginate(25)
        ];
        return view('/purchase/overview', $data);
    }

    /**
     * New purchase view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newView() {

        $data = [
            'products'  => Products::all()
        ];

        return view('/purchase/new', $data);
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
                'quantity'  => 'required',
                'price'     => 'required',
                'discount'  => 'required'
            ];

            $validation = Validator::make($req->all(), $rules);

            if($validation->fails())
                return back()->withErrors($validation)->withInput();

            $transaction = new Transaction();

            $transaction->type = "Purchase";
            $transaction->invoice_id = $req->invoice;
            $transaction->transaction_date = $req->date;
            $transaction->save();

            for($i=0; $i<collect($req->item)->count(); $i++) {
                $purchase = new Purchase();

                $purchase->transaction_id = $transaction->id;
                $purchase->product_id = $req->item[$i];
                $purchase->quantity = $req->quantity[$i];
                $purchase->price = $req->price[$i];
                $purchase->discount = $req->discount[$i];

                $purchase->save();

                //Changes the stock and average price
                $inventory = Products::find($req->item[$i]);

                //Save the inventory to log
                $log = new InventoryLog();

                $log->product_id = $inventory->id;
                $log->product_name = $inventory->product_name;
                $log->description = $inventory->description;
                $log->average_price = $inventory->average_price;
                $log->stock = $inventory->stock;
                $log->save();

                $old_stock = $inventory->stock;
                $avg_price = $inventory->average_price;

                $accumulative_price = $old_stock * $avg_price;
                $accumulative_price += $purchase->price * $purchase->quantity;

                $inventory->stock += $purchase->quantity;
                $inventory->average_price = $accumulative_price / $inventory->stock;
                $inventory->save();
            }

            if ($req->taxinvoice != null && $req->taxinvoicedate != null) {
                $tax_invoice = new TaxInvoice();
                $tax_invoice->invoice_no = $req->taxinvoice;
                $tax_invoice->date = $req->taxinvoicedate;
                $tax_invoice->save();

                $transaction->tax_invoice_id = $tax_invoice->id;
                $transaction->save();
            }
            return redirect('/purchases')->with('success', 'Success adding new purchase');
        }catch(\Exception $e) {
            dd($e->getMessage());
            return redirect('/purchases')->withErrors($e->getMessage());
        }
    }

    /**
     * Edit Purchase View
     * @param Request $req
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editView(Request $req) {

        $purchase = Transaction::with('purchases')->where('id', $req->id)->first();

        $data = [
            'purchase'  => $purchase
        ];

        JavaScript::put([
            'transaction'   => $purchase,
            'items'         => Purchase::where('transaction_id', $purchase->id)->with('product')->get()
        ]);

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
                'quantity'  => 'required',
                'price'     => 'required',
                'discount'  => 'required',
                'id'        => 'required'
            ];

            $validation = Validator::make($req->all(), $rules);

            if($validation->fails())
                return back()->withErrors($validation)->withInput();

            $transaction = Transaction::find($req->id);

            $transaction->invoice_id = $req->invoice;
            $transaction->transaction_date = $req->date;
            $transaction->save();

            foreach($transaction->purchases as $i => $purchase)
            {
                $purchase->transaction_id = $transaction->id;
                $purchase->product_id = $req->item[$i];
                $purchase->quantity = $req->quantity[$i];
                $purchase->price = $req->price[$i];
                $purchase->discount = $req->discount[$i];

                $purchase->save();

                //Changes the stock and average price
                $inventory = Products::find($req->item[$i]);

                //Save the inventory to log
                $log = new InventoryLog();

                $log->product_id = $inventory->id;
                $log->product_name = $inventory->product_name;
                $log->description = $inventory->description;
                $log->average_price = $inventory->average_price;
                $log->stock = $inventory->stock;
                $log->save();

                $old_stock = $inventory->stock;
                $avg_price = $inventory->average_price;

                $accumulative_price = $old_stock * $avg_price;
                $accumulative_price += $purchase->price * $purchase->quantity;

                $inventory->stock += $purchase->quantity;
                $inventory->average_price = $accumulative_price / $inventory->stock;
                $inventory->save();
            }

            if ($req->taxinvoice != null && $req->taxinvoicedate != null) {
                $tax_invoice = TaxInvoice::find($transaction->tax_invoice_id);
                $tax_invoice->invoice_no = $req->taxinvoice;
                $tax_invoice->date = $req->taxinvoicedate;
                $tax_invoice->save();
            }
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
            $purchase = Transaction::find($req->id);
            $purchase->is_active = false;
            $purchase->save();
            return redirect('/purchases')->with('success', 'Success deleting purchase');
        }catch(\Exception $e) {
            return back()->withErrors("Error deleting purchase (Error" . $e->getMessage() . ")");
        }
    }

    /**
     * Get the transaction detail
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function purchaseDetail ($id) {
        return view('/purchase/details', ['transaction' => Transaction::find($id)]);
    }
}
