<?php

namespace App\Http\Controllers;

use App\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Inventory overview
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function overview() {
        $data = [
            'inventories'   => Inventory::paginate(25)
        ];
        return View("inventory.overview", $data);
    }
}
