<?php

namespace App\Http\Controllers;

use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard() {
        $total_transactions = Transaction::whereYear('transaction_date', Carbon::now())->count();
        $total_transactions_last_year = Transaction::whereYear('transaction_date', Carbon::now()->subYear())->count();
        $transaction_decrease = $total_transactions_last_year == 0 ? 0 : 100 - ($total_transactions/$total_transactions_last_year * 100);
        $data = [
            'total_transaction'   => Transaction::whereYear('transaction_date', Carbon::now())->count(),
            'total_transaction_decrease'    => $transaction_decrease,
            'total_sales'  => Transaction::where('type', 'Sales')->count(),
            'total_purchases'  => Transaction::where('type', 'Purchases')->count()
        ];
        return view('dashboard', $data);
    }
}
