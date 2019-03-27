<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxInvoice extends Model
{
    protected $fillable = [
        'invoice_no', 'date', 'used', 'credited', 'is_active', 'customer_id'
    ];

    /**
     * Customer relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function customer() {
        return $this->hasOne(Customers::class, 'id', 'customer_id');
    }
}