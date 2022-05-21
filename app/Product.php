<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $appends = [
        'discounted_price'
    ];

    public function getDiscountedPriceAttribute()
    {
        if($this->discount > 0) {
            return $this->price - ($this->price * ($this->discount / 100));
        }

        return null;
    }

    public function images()
    {
        return $this->hasMany('App\ProductImage', 'product_id');
    }

    public function orders()
    {
        return $this->belongsTo('App\Order', 'product_id');
    }
}
