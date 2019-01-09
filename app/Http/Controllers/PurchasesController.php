<?php

namespace App\Http\Controllers;

use App\Helpers\Queue;
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
     * Datatables
     * @return \Illuminate\Http\JsonResponse
     */
    public function overviewDatatables() {
        return datatables(Transaction::where([
            'type'          => 'Purchase',
            'is_active'     => true
        ])
            ->with('purchases')
            ->get()
        )->toJson();
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

                //If item empty
                if($req->item[$i] == null) {
                    continue;
                }

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

                $log->transaction_id = $transaction->id;
                $log->product_id = $inventory->id;
                $log->product_name = $inventory->product_name;
                $log->description = $inventory->description;
                $log->queue_id = $inventory->queue_id;
                $log->stock_in_queue = $inventory->queue_stock;
                $log->price = $inventory->average_price;
                $log->stock = $inventory->stock;
                $log->save();

                //Set as the lifo if calculation finished
                if($inventory->queue_id == null) {
                    $inventory->queue_id = $purchase->id;
                    $inventory->queue_stock = $purchase->quantity;
                    $inventory->stock = $purchase->quantity;
                }else {
                    $inventory->stock += $purchase->quantity;
                }

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

            $counter = 0;

            foreach($transaction->purchases as $i => $purchase)
            {
                $old_quantity = $purchase->quantity;

                $counter++;
                $purchase->product_id = $req->item[$i];
                $purchase->quantity = $req->quantity[$i];
                $purchase->price = $req->price[$i];
                $purchase->discount = $req->discount[$i];

                $purchase->save();

                //Changes the stock and average price
                $inventory = Products::find($req->item[$i]);

                //Save the inventory to log
                $log = new InventoryLog();

                $log->transaction_id = $transaction->id;
                $log->product_id = $inventory->id;
                $log->product_name = $inventory->product_name;
                $log->description = $inventory->description;
                $log->queue_id = $inventory->queue_id;
                $log->stock_in_queue = $inventory->queue_stock;
                $log->price = $inventory->average_price;
                $log->stock = $inventory->stock;

                $log->save();

                //Check if queue already reach transaction
                if($inventory->queue_id == $purchase->id) {
                    $sold_products = $old_quantity - $inventory->queue_stock;

                    //Check if the new quantity is lower triggering inserting a new queue
                    if($purchase->quantity - $sold_products < 0) {
                        //Go to next queue
                        Queue::takeoutItems($inventory, $sold_products - $purchase->quantity);
                        $inventory->stock += $purchase->quantity - $old_quantity;
                    }else {
                        $inventory->stock += $purchase->quantity - $old_quantity;
                        $inventory->queue_stock += $purchase->quantity - $old_quantity;
                    }
                }else if(Queue::queueHasPassed($inventory, $purchase)) {
                    //Check if the new quantity is lower triggering inserting a new queue
                    if($purchase->quantity < $old_quantity) {
                        //check if cascaded changes goes to next queue
                        if($inventory->queue_stock < $old_quantity - $purchase->quantity) {
                            //Go to next queue
                            Queue::takeoutItems($inventory, $old_quantity - $purchase->quantity);
                            $inventory->stock += $purchase->quantity - $old_quantity;
                        }else {
                            //Cascade background
                            Queue::takeoutItems($inventory, $purchase->quantity - $old_quantity);
                            $inventory->stock += $purchase->quantity - $old_quantity;
                        }
                    }else {
                        $inventory->stock += $purchase->quantity - $old_quantity;
                        $inventory->queue_stock += $purchase->quantity - $old_quantity;
                    }
                }else {
                    $inventory->stock += $purchase->quantity - $old_quantity;
                }

                $inventory->save();
            }

            for($i = $counter; $i<collect($req->price)->count(); $i++){

                //If item empty
                if($req->item[$i] == null) {
                    continue;
                }

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

                $log->transaction_id = $transaction->id;
                $log->product_id = $inventory->id;
                $log->product_name = $inventory->product_name;
                $log->description = $inventory->description;
                $log->queue_id = $inventory->queue_id;
                $log->stock_in_queue = $inventory->queue_stock;
                $log->average_price = $inventory->average_price;
                $log->stock = $inventory->stock;
                $log->save();

                //Set as the lifo if calculation finished
                if($inventory->queue_id == null) {
                    $inventory->queue_id = $purchase->id;
                    $inventory->queue_stock = $purchase->quantity;
                    $inventory->average_price = $purchase->price;
                    $inventory->stock = $purchase->stock;
                }else {
                    $inventory->stock += $purchase->stock;
                }

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
            return redirect('/purchases')->with('success', 'Success hiding purchase');
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
