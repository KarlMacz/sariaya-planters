<?php

namespace App\Http\Traits;

use Auth;

use App\Cart;
use App\OrderLog;

trait Utilities
{
    public $response = [];

    public function flashPrompt($status, $message, $data = null)
    {
        return session()->flash('prompt', [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function getCart()
    {
        if(!Auth::check()) {
            return null;
        }

        return Cart::where('buyer_id', Auth::user()->id)
            ->get();
    }

    public function createOrderLog($order_id, $message)
    {
        $new_order_log = new OrderLog;

        $new_order_log->order_id = $order_id;
        $new_order_log->message = $message;

        return $new_order_log->save();
    }
}
