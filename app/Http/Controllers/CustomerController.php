<?php

namespace App\Http\Controllers;

use App\Customers;
use App\Transaction;
use Illuminate\Http\Request;
use Validator;

class CustomerController extends Controller
{
    /**
     * Customer overview
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function overview() {
        $data = [
            'customers'  => Customers::paginate(25)
        ];
        return view('customer.overview', $data);
    }

    /**
     * Customer detail
     * @param $id customerid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View view
     */
    public function details($id) {
        $data = [
            'customer_detail'       => Customers::find($id)
        ];
        return view('customer.detail', $data);
    }

    /**
     * New Product view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newView() {
        return view('customer.new');
    }

    /**
     * Handle creating new customer record
     * @param Request $req
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleNew (Request $req) {
        $rules = [
            'name'      => 'required',
            'address'   => 'required',
            'phone'     => 'required',
            'email'     => 'required',
            'detail'    => 'required'
        ];

        $validator = Validator::make($req->all(), $rules);

        if($validator->fails()) {
            return redirect('/customers/new')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $customer = new Customers();

            $customer->name = $req->name;
            $customer->address = $req->address;
            $customer->phone = $req->phone;
            $customer->email = $req->email;
            $customer->details = $req->detail;
            $customer->is_active = true;

            $customer->save();
            return redirect('/customers')->with('success', 'Success adding a new customer');
        }catch(\Exception $e){
            return back()->withErrors("Error, (" . $e->getMessage() . ")");
        }
    }

    /**
     * Edit customer view
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editItemView($id) {
        $item = Customers::find($id);
        $data = [
            'customer'  => $item
        ];
        return View("customers/edit", $data);
    }

    /**
     * Handle edit product
     * @param Request $req
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editSubmit(Request $req) {
        $rules = [
            'name'      => 'required',
            'address'   => 'required',
            'phone'     => 'required',
            'email'     => 'required',
            'details'   => 'required',
            'id'        => 'required'
        ];

        $validator = Validator::make($req->all(), $rules);

        if($validator->fails()) {
            return redirect('/customers/new')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $customer = Customers::find($req->id);

            $customer->name = $req->name;
            $customer->address = $req->address;
            $customer->phone = $req->phone;
            $customer->email = $req->email;
            $customer->details = $req->details;
            $customer->is_active = true;

            $customer->save();
            return redirect('/customers')->with('success', 'Success saving customer data');
        }catch(\Exception $e){
            return back()->withErrors("Error, (" . $e->getMessage() . ")");
        }
    }

    /**
     * Delete product
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
}
