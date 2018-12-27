<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'product_name', 'description'
    ];

    public function queue() {
        return $this->hasOne('App\Purchase', 'id', 'queue_id');
    }
}
