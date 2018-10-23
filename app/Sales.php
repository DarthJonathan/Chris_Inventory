<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    public function product() {
        return $this->hasOne('App\Products', 'id', 'product_id');
    }

    public function taxInvoice() {
        return $this->hasOne('App\TaxInvoice', 'id', 'tax_invoice_id');
    }
}
