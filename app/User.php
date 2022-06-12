<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'full_name',
        'full_address'
    ];

    public function getFullNameAttribute()
    {
        if(!empty($this->middle_name)) {
            return $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
        }

        return $this->first_name . ' ' . $this->last_name;
    }

    public function getFullAddressAttribute()
    {
        return $this->address_line . ', ' .
            $this->getBarangay->name . ', ' .
            $this->getMunicipality->name . ', ' .
            $this->getProvince->name . ($this->postal_code != null ? ' ' . $this->postal_code : '');
    }

    public function products()
    {
        return $this->hasMany('App\Product', 'seller_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Order', 'buyer_id');
    }

    public function getBarangay()
    {
        return $this->belongsTo('App\PhBarangay', 'barangay_id');
    }

    public function getMunicipality()
    {
        return $this->belongsTo('App\PhMunicipality', 'municipality_id');
    }

    public function getProvince()
    {
        return $this->belongsTo('App\PhProvince', 'province_id');
    }

    public function hasOrderedProduct($product_id)
    {
        $has_ordered = false;
        $orders = $this->orders;

        if($orders->count() > 0) {
            foreach($orders as $order) {
                if($order->items->count() > 0) {
                    foreach($order->items as $order_item) {
                        if($order_item->product_id == $product_id && $order->status != 'CANCELLED' && $order->status != 'DENIED') {
                            $has_ordered = true;
                        }
                    }
                }
            }
        }

        return $has_ordered;
    }
}
