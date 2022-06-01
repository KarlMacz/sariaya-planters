<?php

namespace App\Http\Traits;

use Auth;

use App\Cart;

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
}
