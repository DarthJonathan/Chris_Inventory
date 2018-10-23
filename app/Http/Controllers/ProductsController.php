<?php

namespace App\Http\Controllers;

use App\Products;
use App\Purchase;
use App\Sales;
use Validator;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Products overview
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function overview() {
        $data = [
            'products'  => Products::paginate(25)
        ];
        return view('products/overview', $data);
    }

    /**
     * New Product view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newView() {
        return view('products/new');
    }

    /**
     * Handle creating new products
     * @param Request $req
     * @return \Illuminate\Http\RedirectResponse
     */
    public function newSubmit (Request $req) {
        $rules = [
            'name'  => 'required'
        ];

        $validator = Validator::make($req->all(), $rules);

        if($validator->fails()) {
            return redirect('/products/new')
                ->withErrors($validator)
                ->withInput();
        }

        $product = new Products();
        $product->product_name = $req->name;
        $product->description = $req->desc;

        $product->save();

        return redirect('/products')->with('success', 'Success adding a new product');
    }

    /**
     * Edit item view
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editItemView($id) {
        $item = Products::find($id);
        $data = [
            'item'  => $item
        ];
        return View("products/edit", $data);
    }

    /**
     * Handle edit product
     * @param Request $req
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editSubmit(Request $req) {

        $rules = [
            'id'    => 'required',
            'name'  => 'required',
            'desc'  => 'required'
        ];

        $validate = Validator::make($req->all(), $rules);

        if($validate->fails()) {
            return back()
                ->withErrors($validate)
                ->withInput();
        }

        try {
            $item = Products::find($req->id);

            $item->product_name = $req->name;
            $item->description = $req->desc;

            $item->save();
        }catch(\Exception $e) {
            return back()->withErrors("Error, (" . $e->getMessage() . ")");
        }
        return redirect('/products')->with('success', 'Product changes are saved');
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
            $purchases = Purchase::where('product_id', $id)->get();
            $sales = Sales::where('product_id', $id)->get();

            if($purchases->count() > 0 || $sales->count() > 0) {
                return back()->withErrors("Product is used for purchases or sales");
            }

            $product = Products::find($id);
            $product->delete();

            return back()->with('success', 'Product Deletion Success!');
        }catch(\Exception $e) {
            return back()->withErrors("Error, ( " . $e->getMessage() . " )");
        }
    }
}
