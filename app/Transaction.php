<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
      'type', 'tax_invoice_id'
    ];

    public function taxInvoice() {
        return $this->hasOne('App\TaxInvoice', 'id', 'tax_invoice_id');
    }

    public function purchases() {
        return $this->hasMany('App\Purchase', 'transaction_id', 'id');
    }

    public function purchase() {
        return $this->hasMany('App\Purchase', 'transaction_id', 'id');
    }

    public function sales() {
        return $this->hasMany('App\Sales', 'transaction_id', 'id');
    }

    public function customer() {
        return $this->hasOne('App\Customers', 'id', 'customer_id');
    }
}
