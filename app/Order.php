<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function paymentMethod()
    {
        $payment_method = null;

        switch($this->payment_method) {
            case 'COD':
                $payment_method = 'Cash on Delivery';

                break;
            case 'BANK':
                $payment_method = 'Thru Bank';

                break;
            case 'E-WALLET':
                $payment_method = 'Sent via E-wallet';

                break;
            default:
                break;
        }

        return $payment_method;
    }

    public function items()
    {
        return $this->hasMany('App\OrderItem', 'order_id');
    }

    public function buyer()
    {
        return $this->belongsTo('App\User', 'buyer_id');
    }

    public function logs()
    {
        return $this->hasMany('App\OrderLog', 'order_id');
    }
}
