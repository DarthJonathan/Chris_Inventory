<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public function product() {
        return $this->hasOne('App\Products', 'id', 'product_id');
    }

    public function transaction () {
        return $this->hasOne('App\Transaction', 'id', 'transaction_id');
    }
}
