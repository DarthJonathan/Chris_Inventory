<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class CustomerTaxInvoicePivot extends Model
{
    protected $fillable = [
        'customer_id', 'tax_invoice_id', 'date'
    ];

    public function customer() {
        return $this->hasOne(Customers::class, 'id', 'customer_id');
    }

    public function transaction () {
        return $this->hasOne(TaxInvoice::class, 'id', 'tax_invoice_id');
    }
}
