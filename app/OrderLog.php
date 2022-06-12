<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderLog extends Model
{
    public function order()
    {
        return $this->hasMany('App\Order', 'order_id');
    }
}
