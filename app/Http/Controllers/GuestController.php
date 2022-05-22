<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;

class GuestController extends Controller
{
    public function showIndex()
    {
        return view('guest.index');
    }

    public function showShop()
    {
        $products = Product::where('is_displayed', true)
            ->where('quantity', '>', 0)
            ->get();

        return view('guest.shop', [
            'products' => $products
        ]);
    }

    public function showProduct($id)
    {
        $id = base64_decode($id);

        $product = Product::where('is_displayed', true)
            ->where('id', $id)
            ->first();

        return view('guest.product', [
            'product' => $product
        ]);
    }

    public function showTest()
    {
        //
    }
}
