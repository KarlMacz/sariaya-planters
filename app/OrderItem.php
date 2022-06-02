<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $appends = [
        'discounted_price'
    ];

    public function getDiscountedPriceAttribute()
    {
        if($this->at_discount > 0) {
            return $this->at_price - ($this->at_price * ($this->at_discount / 100));
        }

        return null;
    }

    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
}
