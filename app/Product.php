<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $appends = [
        'discounted_price',
        'rating'
    ];

    public function getDiscountedPriceAttribute()
    {
        if($this->discount > 0) {
            return $this->price - ($this->price * ($this->discount / 100));
        }

        return null;
    }

    public function getRatingAttribute()
    {
        return 0;
    }

    public function seller()
    {
        return $this->belongsTo('App\User', 'seller_id');
    }

    public function images()
    {
        return $this->hasMany('App\ProductImage', 'product_id');
    }

    public function orders()
    {
        return $this->belongsTo('App\Order', 'product_id');
    }

    public function carts()
    {
        return $this->hasMany('App\Cart', 'product_id');
    }
}
