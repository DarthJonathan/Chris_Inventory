<?php

namespace App\Http\Controllers;

use App\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Get the sales list
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list () {
        $data = [
          'sales'   => Sales::paginate(25)
        ];
        return View("sales.overview", $data);
    }
}
