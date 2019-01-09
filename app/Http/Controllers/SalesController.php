<?php

namespace App\Http\Controllers;

use App\Helpers\Queue;
use App\InventoryLog;
use App\Products;
use App\Purchase;
use App\Sales;
use App\TaxInvoice;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;

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
     * Datatables
     * @return \Illuminate\Http\JsonResponse
     */
    public function overviewDatatables() {
        return datatables(Transaction::where([
            'type'          => 'Sales',
            'is_active'     => true
        ])
            ->with('sales')
            ->get()
        )->toJson();
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
            'item'          => 'required',
            'discount'      => 'required',
            'sales_date'    => 'required',
            'quantity'      => 'required'
        ];

        $validate = Validator::make($req->all(), $rules);

        if($validate->fails())
            return back()->withErrors($validate)->withInput();

        try {
            $today = Carbon::now();

            //Get the previous day invoice
            $last_today = Sales::whereDate('created_at', Carbon::today())->get()->count();
            $invoice_number = 'INV-' . $today->format('md') . '-' . str_pad($last_today, 3, STR_PAD_LEFT) . '-' . $today->format('y');

            $transaction = new Transaction();
            $transaction->type = "Sales";
            $transaction->invoice_id = $invoice_number;
            $transaction->transaction_date = $req->sales_date;
            $transaction->save();

            $tax_invoice = null;

            if($req->taxinvoice != null && $req->taxinvoicedate != null) {
                $tax_invoice = new TaxInvoice();
                $tax_invoice->invoice_no = $req->taxinvoice;
                $tax_invoice->date = $req->taxinvoicedate;
                $tax_invoice->save();
            }

            for($i=0; $i<collect($req->item)->count(); $i++){
                $sale = new Sales();
                $sale->transaction_id = $transaction->id;
                $sale->price = $req->price[$i];
                $sale->product_id = $req->item[$i];
                $sale->discount = $req->discount[$i];
                $sale->quantity = $req->quantity[$i];
                $sale->sales_date = $today;

                //Check for tax invoice
                if($req->tax_invoice_id != null) {
                    $sale->tax_invoice_id = $req->tax_invoice_id;
                    $sale->save();
                }else if($req->taxinvoice != null && $req->taxinvoicedate != null) {
                    $sale->tax_invoice_id = $tax_invoice->id;
                    $sale->save();
                }else {
                    $sale->save();
                }

                //Changes the stock and average price
                $inventory = Products::find($req->item[$i]);
                Queue::takeoutItems($inventory, $sale->quantity);
                $inventory->save();
            }

            return redirect('/sales')->with('success', 'Success adding new sale data');
        }catch(\Exception $e) {
            dd($e->getMessage());
            return back()->withErrors("Error creating new record (Error : " . $e->getMessage() . " )");
        }
    }

    /**
     * Get the sales transaction detail
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail ($id){
        $transaction = Transaction::find($id);
        return view('sales.details', ['transaction' => $transaction]);
    }

    /**
     * Edit view
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editView($id) {
        $transaction = Transaction::with('sales')->where('id', $id)->first();

        JavaScript::put([
            'transaction'   => $transaction,
            'items'         => Sales::where('transaction_id', $transaction->id)->with('product')->get()
        ]);

        return view('sales.edit', ['transaction' => $transaction]);
    }

    /**
     * Handle edit
     * @param Request $req
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleEdit(Request $req)
    {
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

            foreach($transaction->sales as $i => $sale)
            {
                $counter++;
                $sale->product_id = $req->item[$i];
                $sale->quantity = $req->quantity[$i];
                $sale->price = $req->price[$i];
                $sale->discount = $req->discount[$i];

                $sale->save();

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
                $accumulative_price -= $sale->price * $sale->quantity;

                $inventory->stock -= $sale->quantity;
                $inventory->average_price = $accumulative_price / $inventory->stock;
                $inventory->save();
            }

            for($i = $counter; $i<collect($req->price)->count(); $i++){
                $sale = new Sales();
                $sale->transaction_id = $transaction->id;
                $sale->product_id = $req->item[$i];
                $sale->quantity = $req->quantity[$i];
                $sale->price = $req->price[$i];
                $sale->discount = $req->discount[$i];

                $sale->save();

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
                $accumulative_price -= $sale->price * $sale->quantity;

                $inventory->stock -= $sale->quantity;
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
            return back()->withErrors("Error  changes (Error" . $e->getMessage() . ")");
        }
    }

    public function delete(Request $req)
    {
        try {


            return redirect('/purchases')->with('success', 'Success deleting sales');
        }catch(\Exception $e) {
            return back()->withErrors("Error  changes (Error" . $e->getMessage() . ")");
        }
    }
}
